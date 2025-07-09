<?php

namespace Core\Http\Controllers\Tenant;

use Core\Models\TlPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Core\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Core\Repositories\LanguageRepository;
use Illuminate\Support\Facades\Validator;
use Core\Repositories\Tenant\PageRepository;

class PageController extends Controller
{
  protected $language_repository;
  protected $page_repository;

  public function __construct(LanguageRepository $language_repository, PageRepository $page_repository)
  {
    $this->language_repository = $language_repository;
    $this->page_repository = $page_repository;
  }

  /**
   ** Show all the pages from database and get all the categories under the pages
   * @return mixed
   */
  public function page(Request $request)
  {
    try {

      $query = TlPage::with(['page_translations', 'parentPage' => function ($q) {
        $q->with(['page_translations']);
      }]);


      if ($request->has('status') && $request['status'] != null) {

        switch ($request->status) {
          case 'mine':
            $query = $query->where('user_id', auth()->user()->id);
            break;
          case 'publish':
            $query = $query->where('publish_status', config('settings.page_status.publish'))
              ->orWhere('publish_at', '<', currentDateTime());
            break;
          case 'schedule':
            $query = $query->where('publish_at', '>', currentDateTime());
            break;
          case 'draft':
            $query = $query->where('publish_at', '=',  config('settings.page_status.draft'));
            break;
          case 'trash':
            $query = $query->where('publish_at', '=',  config('settings.page_status.trash'));
            break;
          case 'search_text':
            $query = $query;
            break;
          default:
            $query = $query;
            break;
        }
      }
      if ($request->has('search') && $request['search'] != null) {
        $query = $query->where('title', 'like', '%' . $request['search'] . '%');
      }
      $per_page = 10;
      if ($request->per_page) {
        $per_page = (int)$request->per_page;
      }
      $pages = $query->paginate($per_page)->withQueryString();

      return view('core::base.tenant.pages.pages', compact('pages'));
    } catch (\Exception $e) {
      toastNotification('error', translate('Pages Not Found'));
      return redirect()->back();
    }
  }

  /**
   ** Show the add page for adding a new page
   *
   * @return mixed
   */
  public function addPage()
  {
    try {
      $data = [
        DB::raw('GROUP_CONCAT(distinct tl_pages.id) as id'),
        DB::raw('GROUP_CONCAT(distinct tl_pages.title) as title'),
        DB::raw('GROUP_CONCAT(distinct tl_pages.permalink) as permalink'),
        DB::raw('GROUP_CONCAT(distinct tl_pages.parent) as parent'),
      ];
      $match_case = [
        ['tl_pages.publish_status', '=',  config('settings.page_status.publish')],
        ['tl_pages.parent', '=',  null]
      ];
      $pages = $this->page_repository->getPages($data, $match_case)->get();
      $page_templates = $this->page_repository->getPageTemplates()->get();
      return view('core::base.tenant.pages.add_page', compact('pages', 'page_templates'));
    } catch (\Exception $e) {
      toastNotification('error', translate('Something Went Wrong'));
      return to_route('core.page');
    }
  }

  /**
   ** Store a new page as Publish to DB
   * @param \Core\Http\Requests\PageRequest $request
   * @return \Illuminate\Http\Response
   */

  public function storePage(PageRequest $request)
  {
    try {
      DB::beginTransaction();
      $page = $this->page_repository->pageCreateUpdate($request, isset($request->id) ? $request->id : null);
      DB::commit();

      toastNotification('success', translate('New Page Saved'));
      return redirect()->route('core.page.edit', ['permalink' =>  $page->permalink, 'lang' => getDefaultLang()]);
    } catch (\Exception $e) {
      DB::rollBack();
      toastNotification('error', translate('New Page Saving Failed'));
      return redirect()->route('core.page.add');
    }
  }

  /**
   ** Edit Page
   * @return View
   */
  public function editPage(Request $request)
  {
    try {
      if ($request->permalink && $request->lang) {
        $languages = $this->language_repository->allLanguages();
        $lang =  $request->lang;

        $page = $this->page_repository->findPage($request->permalink);
        $page->page_password = isset($page->page_password) ? Crypt::decrypt($page->page_password) : null;
        $page->content = fix_image_urls($page->content);

        $data = [
          DB::raw('GROUP_CONCAT(distinct tl_pages.id) as id'),
          DB::raw('GROUP_CONCAT(distinct tl_pages.title) as title'),
          DB::raw('GROUP_CONCAT(distinct tl_pages.permalink) as permalink'),
          DB::raw('GROUP_CONCAT(distinct tl_pages.parent) as parent'),
        ];
        $match_case = [
          ['tl_pages.publish_status', '=',  config('settings.page_status.publish')],
          ['tl_pages.parent', '=',  null]
        ];
        $parent_pages = $this->page_repository->getPages($data, $match_case)->get();
        $page_templates = $this->page_repository->getPageTemplates()->get();
        return view('core::base.tenant.pages.edit_page', compact('page', 'parent_pages', 'page_templates', 'languages', 'lang'));
      } else {
        toastNotification('error', translate('Page not found'));
        return redirect()->route('core.page');
      }
    } catch (\Exception $e) {
      toastNotification('error', translate('Page not found'));
      return redirect()->route('core.page');
    }
  }

  /**
   ** Update Page
   * @param \App\Http\Requests\PageRequest $request
   * @return \Illuminate\Http\Response
   */
  public function updatePage(PageRequest $request)
  {
    try {
      if ($request->permalink && $request->lang) {
        DB::beginTransaction();
        $this->page_repository->pageUpdate($request);
        DB::commit();
        toastNotification('success', translate('Page Updated Successfully'));
        return redirect()->route('core.page.edit', ['permalink' =>  $request->permalink, 'lang' => $request->lang]);
      } else {
        toastNotification('error', translate('Page Update Failed'));
        return redirect()->route('core.page.edit', ['permalink' =>  $request->permalink, 'lang' => $request->lang]);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      toastNotification('error', translate('Page Update Failed'));
      return redirect()->back();
    }
  }

  /**
   ** Delete Page 
   * @param $request TlPage permalink
   * @return View
   */
  public function deletePage(Request $request)
  {
    try {
      if (isset($request->permalink)) {
        DB::beginTransaction();
        $pageDeleteResult = $this->page_repository->deletePage($request->permalink);
        DB::commit();
        toastNotification($pageDeleteResult['status'], $pageDeleteResult['message']);
      } else {
        toastNotification('error', translate('Page Deleting Failed'));
      }
    } catch (\Exception $e) {
      DB::rollBack();
      toastNotification('error', translate('Page Deleting Failed'));
    }

    return redirect()->route('core.page');
  }

  /**
   * Bulk Delete Page
   * @param \Illuminate\Http\Request $request (Via Ajax)
   * @return \Illuminate\Http\Response (Via Ajax)
   */
  public function bulkDeletePage(Request $request)
  {
    try {
      if ($request->has('data')) {
        DB::beginTransaction();
        $this->page_repository->bulkDeletePage($request->data);
        DB::commit();
        toastNotification('success', translate('Pages Bulk Delete Successful'));
      } else {
        toastNotification('error', translate('Pages Bulk Deleting Failed'));
      }
    } catch (\Exception $e) {
      DB::rollBack();
      toastNotification('error', translate('Pages Bulk Deleting Failed'));
    }
  }

  /**
   ** Page Draft and Preview Save in Database
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function pageDraftPreview(Request $request)
  {
    // title Field is required
    if (!isset($request->title)) {
      return response()->json(['error' => translate('Title Field is Required')]);
    }
    // Checking if title and permalink already exist or not
    if (!$request->id && (TlPage::where('permalink', $request->permalink)->exists() || TlPage::where('title', $request->title)->exists())) {
      return response()->json(['error' => translate('This Page Title or Permalink is Already Available Please Insert Different Title or Permalink')]);
    }
    $page = $this->page_repository->pageCreateUpdate($request, isset($request->id) ? $request->id : null, $request->action);
    switch ($request->action) {
      case 'draft':
        return response()->json(['success' => translate('Page Draft Saved'), 'id' => $page->id]);
        break;

      case 'preview':
        return response()->json(['id' => $page->id, 'permalink' => $page->permalink]);
        break;
    }
  }

  /**
   ** blog preview page
   * @return View
   */
  public function pagePreview($slug)
  {
    try {
      $active_theme = getActiveTheme();

      $page = $this->page_repository->findPage($slug);
      if ($page == null) {
        abort(404);
      }
      $page_sections = '';

      if (isActivePluging('tlcommerce-pagebuilder') &&  $page->page_type == 'builder') {
        $page_sections = \Plugin\TlPageBuilder\Helpers\BuilderHelper::getSectionLayoutWidgets($page->id, Session::get('api_locale'));
      }

      return view("theme/{$active_theme->location}::backend.page_preview", compact('page', 'page_sections'));
    } catch (\Exception $e) {
      abort(404);
    }
  }


  /**
   ** Page Content (SummerNote) Image Upload and validate to send a response
   * @param \Illuminate\Http\Request $request
   * @return mixed
   */
  public function pageContentImage(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'image' => 'required|image|mimes:jpg,png,svg,jpeg,bmp|max:1040',
    ]);

    if ($validator->passes()) {
      $file = $request->file('image');
      $file_id = saveFileInStorage($file);
      $path = getFilePath($file_id);

      return response()->json(['url' => $path]);
    }
    return response()->json(['error' => $validator->errors()->all()]);
  }

  /**
   ** page status change
   * @param $request TlPage permalink
   * @return View
   */
  public function pageStatusChange(Request $request)
  {
    try {
      if (isset($request->permalink) && isset($request->status)) {
        DB::beginTransaction();
        $result = $this->page_repository->pageChangeToTrash($request);
        DB::commit();
        toastNotification($result['status'], $result['message']);
        return redirect()->back();
      } else {
        toastNotification('error', translate('Page Status Changing Failed'));
        return redirect()->back();
      }
    } catch (\Exception $e) {
      DB::rollBack();
      toastNotification('error', translate('Page Status Changing Failed'));
      return redirect()->route('core.page');
    }
  }

  /**
   * Update Page Home Status
   */
  public function makeHomepage(TlPage $page)
  {
    try {

      if (!isActivePluging('tlcommerce-pagebuilder') || $page == null) {
        abort(404);
      }

      DB::beginTransaction();

      TlPage::query()->update(['is_home' => false]);
      $page->update(['is_home' => !$page->is_home]);

      DB::commit();

      toastNotification('success', translate('Page Home Status Updated'));
      return redirect()->back();
    } catch (\Exception $e) {
      DB::rollBack();
      toastNotification('error', translate('Page Make Home Failed'));
      return redirect()->route('core.page');
    }
  }
}
