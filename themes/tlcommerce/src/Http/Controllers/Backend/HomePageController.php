<?php

namespace Theme\TLCommerce\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Core\Models\ThemeTranslations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Theme\TLCommerce\Models\HomePageSection;
use Core\Exceptions\ThemeRequiredPluginException;
use Theme\TLCommerce\Models\HomeSectionProperties;
use Theme\TLCommerce\Http\Requests\HomePageSectionRequest;

class HomePageController extends Controller
{
    /**
     * Will return home page sections
     * 
     * @return mixed
     */
    public function homePageSections()
    {
        $sections = HomePageSection::orderBy('ordering')->get();
        return view('theme/tlcommerce::backend.homepage.home_page_sections')->with(
            [
                'sections' => $sections
            ]
        );
    }
    /**
     * Redirect to new section page
     * 
     * @return mixed
     */
    public function newHomePageSection()
    {
        return view('theme/tlcommerce::backend.homepage.new_home_page_section');
    }
    /**
     * Will sorting home page sections
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function sortingHomePageSection(Request $request)
    {
        try {
            $position = 0;
            foreach ($request['item'] as $item_id) {
                $position++;
                $section = HomePageSection::find($item_id);
                $section->ordering = $position;
                $section->save();
            }
            $this->resetHomepageSectionCache();
            toastNotification('success', translate('Successfully rearranging'));
        } catch (\Exception $e) {
            toastNotification('error', translate('Action Failed'));
        }
    }
    /**
     * Will remove home page section
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function removeHomePageSection(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = HomePageSection::findOrFail($request['id']);
            $section->section_properties()->delete();
            $section->delete();
            DB::commit();
            $this->resetHomepageSectionCache();
            toastNotification('success', translate('Section deleted successfully'));
            return redirect()->route('theme.tlcommerce.home.page.sections');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Action Failed'));
            return redirect()->back();
        }
    }
    /**
     * Will update home section status
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function updateHomePageSectionStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = HomePageSection::findOrFail($request['id']);
            $status = config('settings.general_status.active');
            if ($section->status == config('settings.general_status.active')) {
                $status = config('settings.general_status.in_active');
            }
            $section->status = $status;
            $section->save();
            DB::commit();
            $this->resetHomepageSectionCache();
            toastNotification('success', translate('Status updated successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Action Failed'));
        }
    }
    /**
     * Will return layout options
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function layoutOptions(Request $request)
    {
        //Flash deal Section properties
        if ($request['layout'] == 'flashdeal') {
            $deals = [];
            if (isActivePluging('flashdeal')) {
                $deals = \Plugin\Flashdeal\Models\FlashDeal::where('status', config('settings.general_status.active'))->get();
            }
            return view('theme/tlcommerce::backend.homepage.sections.flash_deal.deal_options')->with(
                [
                    'deals' => $deals
                ]
            );
        }
        //Product Collection Properties
        if ($request['layout'] == 'product_collection') {
            $collections = [];
            if (isActivePluging('tlecommercecore')) {
                $collections = \Plugin\TlcommerceCore\Models\ProductCollection::where('status', config('settings.general_status.active'))->get();
            }
            return view('theme/tlcommerce::backend.homepage.sections.product_collection.collection_options')->with(
                [
                    'collections' => $collections
                ]
            );
        }

        //Ads Section Properties
        if ($request['layout'] == 'ads') {
            return view('theme/tlcommerce::backend.homepage.sections.ads.ads_options');
        }

        //Blog Section Properties
        if ($request['layout'] == 'blogs') {
            return view('theme/tlcommerce::backend.homepage.sections.blogs.blogs_options');
        }
        //Featured Product Section Properties
        if ($request['layout'] == 'featured_product') {
            return view('theme/tlcommerce::backend.homepage.sections.featured_product.featured_product_options');
        }

        //Category Section Properties
        if ($request['layout'] == 'category_slider') {
            return view('theme/tlcommerce::backend.homepage.sections.category_slider.category_slider_options');
        }
        //Custom Product Collection Section Properties
        if ($request['layout'] == 'custom_product_section') {
            return view('theme/tlcommerce::backend.homepage.sections.custom_collection.custom_product_section_options');
        }

        //Seller Section Properties
        if ($request['layout'] == 'seller_list') {
            return view('theme/tlcommerce::backend.homepage.sections.seller_list.seller_section_options');
        }
    }
    /**
     * Will return ads layout options
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function adsLayoutOptions(Request $request)
    {
        return view('theme/tlcommerce::backend.homepage.sections.ads.ads_layout_options')->with(
            [
                'layout' => $request['layout'],
            ]
        );
    }
    /**
     * Will store new home page section
     * 
     * @param HomePageSectionRequest $request
     * @return mixed
     */
    public function storeNewHomePageSection(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = new HomePageSection();
            $section->save();
            foreach ($request->except(['_token', 'sellers']) as $key => $value) {
                $section_properties = new HomeSectionProperties();
                $section_properties->section_id = $section->id;
                $section_properties->key_name = $key;
                $section_properties->key_value = xss_clean($value);
                $section_properties->save();
            }

            if ($request->has('sellers')) {
                $seller_str = implode(',', $request['sellers']);
                $seller_section_properties = new HomeSectionProperties();
                $seller_section_properties->section_id = $section->id;
                $seller_section_properties->key_name = 'content';
                $seller_section_properties->key_value = $seller_str;
                $seller_section_properties->save();
            }


            DB::commit();

            if ($request->has('title') && $request['title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['title']));
            }
            if ($request->has('meta_title') && $request['meta_title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['meta_title']));
            }
            if ($request->has('btn_title') && $request['btn_title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['btn_title']));
            }
            if ($request->has('featured_title') && $request['featured_title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['featured_title']));
            }

            $this->resetHomepageSectionCache();
            toastNotification('success', translate('New Section added successfully'));
            return redirect()->route('theme.tlcommerce.home.page.sections');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Save failed'));
            return redirect()->back();
        }
    }

    /**
     * Will redirect edit section page
     * 
     * @param Int $id
     * @return mixed
     */
    public function editHomePageSection($id)
    {
        $section_details = HomePageSection::find($id);
        if (getHomePageSectionProperties($section_details->id, 'layout') == 'seller_list' && !isActivePluging('multivendor')) {
            throw new ThemeRequiredPluginException('Multivendor plugin not found. Please activate multivendor plugin');
        }

        return view('theme/tlcommerce::backend.homepage.edit_home_page_section')->with(
            [
                'section_details' => $section_details,
            ]
        );
    }

    /**
     * Will update home section
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function updateHomePageSection(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = HomePageSection::find($request['id']);
            $section->section_properties()->delete();
            $section->save();
            foreach ($request->except(['_token', 'id', 'sellers']) as $key => $value) {
                $section_properties = new HomeSectionProperties;
                $section_properties->section_id = $section->id;
                $section_properties->key_name = $key;
                $section_properties->key_value = xss_clean($value);
                $section_properties->save();
            }

            if ($request->has('sellers')) {
                $seller_str = implode(',', $request['sellers']);
                $seller_section_properties = new HomeSectionProperties;
                $seller_section_properties->section_id = $section->id;
                $seller_section_properties->key_name = 'content';
                $seller_section_properties->key_value = $seller_str;
                $seller_section_properties->save();
            }
            DB::commit();
            if ($request->has('title') && $request['title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['title']));
            }
            if ($request->has('btn_title') && $request['btn_title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['btn_title']));
            }
            if ($request->has('meta_title') && $request['meta_title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['meta_title']));
            }
            if ($request->has('featured_title') && $request['featured_title'] != null) {
                $this->storeFrontendTranslation(xss_clean($request['featured_title']));
            }

            $this->resetHomepageSectionCache();
            toastNotification('success', translate('Section updated successfully'));
            return redirect()->route('theme.tlcommerce.home.page.sections.edit', ['id' => $request['id']]);
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Update failed'));
            return redirect()->back();
        }
    }

    /**
     * will store section title and button translation
     * 
     * @param String $key
     * @return void
     */
    public function storeFrontendTranslation($key)
    {
        $active_theme = getActiveTheme();
        $translation = ThemeTranslations::where('lang', 'en')->where('theme', $active_theme->location)->where('lang_key', $key)->first();
        if ($translation == null) {
            $new_translation = new ThemeTranslations;
            $new_translation->lang = 'en';
            $new_translation->theme = $active_theme->location;
            $new_translation->lang_key = $key;
            $new_translation->lang_value = $key;
            $new_translation->save();
        }
        return true;
    }

    /**
     * Will reset home page sections cache
     */
    public function resetHomepageSectionCache()
    {

        cache()->forget('home-page-sections-properties');
        Cache::remember("home-page-sections-properties", 100 * 60, function () {
            return HomeSectionProperties::all();
        });

        cache()->forget('home-page-sections');
        Cache::remember("home-page-sections", 100 * 60, function () {
            return
                HomePageSection::with(['section_properties' => function ($q) {
                    $q->select('section_id', 'key_name', 'key_value');
                }])->where('status', config('settings.general_status.active'))
                ->select('id', 'ordering')
                ->orderBy('ordering', 'ASC')
                ->get();
        });
    }
}
