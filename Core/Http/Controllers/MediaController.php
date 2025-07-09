<?php

namespace Core\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Core\Models\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Core\Http\Requests\MediaRequest;
use Illuminate\Support\Facades\Auth;
use Core\Repositories\MediaRepository;
use Illuminate\Support\Facades\Storage;
use Core\Repositories\SettingsRepository;
use Core\Models\WatermarkApplicableFolder;

class MediaController extends Controller
{

    protected $media_repo;
    protected $settings_repository;

    public function __construct(MediaRepository $media_repo, SettingsRepository $settings_repository)
    {
        $this->media_repo = $media_repo;
        $this->settings_repository = $settings_repository;
    }

    /*new */
    /**
     * will redirect to image settings page
     *
     * @return mixed
     */
    public function imageSettings()
    {
        return view('core::base.media.image_settings');
    }

    /*new */
    /**
     * store media settings
     *
     * @param  mixed $request
     * @return void
     */
    public function storeMediaSettings(MediaRequest $request)
    {

        try {
            DB::beginTransaction();
            foreach ($request->except(['_token', 'watermark_status', 'aws_access_key_id', 'aws_secret_access_key', 'aws_default_region', 'aws_bucket', 'aws_endpoint']) as $key => $value) {
                setGeneralSetting($key, xss_clean($value));
            }
            $watermark_status = $request->has('watermark_status') ? 'on' : 'off';
            setGeneralSetting('watermark_status', xss_clean($watermark_status));

            //set aws s3 credentials
            if ($request->has('file_storage') && $request['file_storage'] == 'amazons3') {
                setEnv('AWS_ACCESS_KEY_ID', $request['aws_access_key_id']);
                setEnv('AWS_SECRET_ACCESS_KEY', $request['aws_secret_access_key']);
                setEnv('AWS_DEFAULT_REGION', $request['aws_default_region']);
                setEnv('AWS_BUCKET', $request['aws_bucket']);
                setEnv('AWS_URL', $request['aws_endpoint']);
            }

            DB::commit();
            toastNotification('success', 'Media settings updated successfully');
            return redirect()->route('core.image.settings');
        } catch (Exception $ex) {
            DB::rollBack();
            toastNotification('error', 'Unable to update media settings');
            return redirect()->route('core.image.settings');
        }
    }

    /**
     * Redirect to media page 
     */
    public function mediaPage()
    {
        return view('core::base.media.index');
    }

    /*new */
    /**
     * upload media file
     *
     * @param  mixed $request
     * @return void
     */
    public function uploadMediaFile(Request $request)
    {
        try {
            foreach ($request->file('file') as $file) {
                $file_id = saveFileInStorage($file, true);
            }

            $total = DB::table('tl_uploaded_files')->count();

            return [
                'success' => true,
                'file_id' => $file_id,
                'is_complete' => true,
                'total' => $total,
                'message' => translate("Media file uploaded successful")
            ];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => translate("Unable to update media file")
            ], 500);
        }
    }

    /**
     * Apply watermark image
     */
    public function applyWatermarkImage(Request $request)
    {
        $image_information = DB::table('tl_uploaded_files')->where('id', '=', $request['file_id'])->first();
        $image_name = $image_information->name;
        $folder_name = $image_information->folder_name;
        $extension = explode('.', $image_information->path)[1];

        $large_thumb_image = DB::table('tl_general_settings_has_values')
            ->whereIn('settings_id', [
                getGeneralSettingId('large_thumb_image_width'),
                getGeneralSettingId('large_thumb_image_height')
            ])->pluck('value')->toArray();

        $medium_thumb_image = DB::table('tl_general_settings_has_values')
            ->whereIn('settings_id', [
                getGeneralSettingId('medium_thumb_image_width'),
                getGeneralSettingId('medium_thumb_image_height')
            ])->pluck('value')->toArray();

        $small_thumb_image = DB::table('tl_general_settings_has_values')
            ->whereIn('settings_id', [
                getGeneralSettingId('small_thumb_image_width'),
                getGeneralSettingId('small_thumb_image_height')
            ])->pluck('value')->toArray();

        applyWaterMarkImage($image_name, $folder_name, $extension, $large_thumb_image[0], $large_thumb_image[1]);
        applyWaterMarkImage($image_name, $folder_name, $extension, $medium_thumb_image[0], $medium_thumb_image[1]);
        applyWaterMarkImage($image_name, $folder_name, $extension, $small_thumb_image[0], $small_thumb_image[1]);
    }

    /**
     * update media file info
     *
     * @param  mixed $request
     * @return void
     */
    public function updateMediaFileInfo(Request $request)
    {
        try {
            $file = UploadedFile::find($request['media_id']);
            $file->title       = xss_clean($request['title']);
            $file->caption     = xss_clean($request['caption']);
            $file->alt         = xss_clean($request['alt']);
            $file->description = xss_clean($request['description']);
            $file->update();

            return response()->json([
                'success' => true,
                'message' => translate("Media information updated successful")
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate("Unable to media information")
            ], 500);
        }
    }

    /**
     * Filter media list
     */
    public function filterMediaList(Request $request)
    {
        try {
            $selected_file_type = $request['file_type'];
            $selected_media_type = $request['media_type'];
            $search_input = $request['search_input'];
            $search_date = $request['search_date'];
            $filter_by_user = $request['filter_by_user'];

            $match_case = [];

            if ($selected_file_type != null && $selected_file_type != '' && $selected_file_type != 'all') {
                array_push($match_case, [
                    'tl_uploaded_files.file_type',
                    '=',
                    $selected_file_type
                ]);
            }

            if ($selected_media_type != null && $selected_media_type != '' && $selected_media_type != 'all') {
                array_push($match_case, [
                    'tl_uploaded_files.media_type',
                    '=',
                    $selected_media_type
                ]);
            }

            if ($search_date != null && $search_date != '' && $search_date != 'all') {
                $search_date_splitted = explode('-', $request['search_date']);
                $starting_date = $search_date_splitted[1] . '-' . $search_date_splitted[0] . '-' . '01' . " 00:00:00";
                $ending_date = $search_date_splitted[1] . '-' . $search_date_splitted[0] . '-' . '31' . " 00:00:00";

                array_push($match_case, [
                    'tl_uploaded_files.created_at',
                    '>=',
                    $starting_date
                ]);
                array_push($match_case, [
                    'tl_uploaded_files.created_at',
                    '<=',
                    $ending_date
                ]);
            }

            if ($filter_by_user == 'true') {
                array_push($match_case, [
                    'tl_uploaded_files.user_id',
                    '=',
                    Auth::user()->id
                ]);
            }

            $all_media = $this->media_repo->getMediaList($match_case, $request['selected_media_files'], $search_input, true);

            $media_ids = $all_media->map(function ($item) {
                return $item->id;
            });

            return response()->json([
                'view' => view('core::base.media.partial.media_list', compact('all_media', 'selected_file_type', 'selected_media_type', 'search_input', 'search_date', 'media_ids'))->render(),
                'all_media' => $all_media
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate("Media list filtered unsuccessful")
            ], 500);
        }
    }

    /*new */
    /**
     * Delete media file
     */
    public function deleteMediaFile(Request $request)
    {
        try {
            $ids = $request['id'];
            for ($i = 0; $i < sizeof($ids); $i++) {
                removeMediaById((int)$ids[$i]);
            }
            return response()->json([
                'success' => true,
                'message' => translate('File deleted successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => translate("Unable to delete file")
            ], 500);
        }
    }

    /*new */
    /**
     * get media details by file id
     */
    public function getMediaDetailsById(Request $request)
    {
        try {
            $selected_media = UploadedFile::findOrFail($request['selected_media_id']);
            $selected_media->path = getFilePath($selected_media->id);

            $details_view = "";

            if ($request['is_for_browse_file'] == 'true') {
                $details_view = view('core::base.media.partial.media_details_side_bar', ['details' => $selected_media])->render();
            }

            if ($request['is_for_browse_file'] == 'false') {
                $details_view = view('core::base.media.partial.media_details_pop_up', ['details' => $selected_media])->render();
            }


            return response()->json([
                'success' => true,
                'details_view' => $details_view,
                'media_details' => $selected_media
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false
            ], 500);
        }
    }
}
