<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ApplyWaterMarkImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $path = $data['folder_name'] . '/' . $data['image_name'] . $data['width'] . 'x' . $data['height'] . '.' . $data['extension'];
        $img = Image::make('public/' . $path);



        $watermark_image_opacity = null;
        $watermark_image_position = null;
        $watermark_image_id = null;
        $watermark_image_location = null;

        $watermark_image_opacity_object = DB::table('tl_general_settings_has_values')
            ->where('settings_id', '=', getGeneralSettingId('water_marking_image_opacity'))
            ->first();

        if ($watermark_image_opacity_object != null) {
            $watermark_image_opacity = $watermark_image_opacity_object->value;
        }

        $watermark_image_position_object = DB::table('tl_general_settings_has_values')
            ->where('settings_id', '=', getGeneralSettingId('watermark_image_position'))
            ->first();

        if ($watermark_image_position_object != null) {
            $watermark_image_position = $watermark_image_position_object->value;
        }

        $watermark_image_id_object = DB::table('tl_general_settings_has_values')
            ->where('settings_id', '=', getGeneralSettingId('watermark_image'))
            ->first();

        if ($watermark_image_id_object != null) {
            $watermark_image_id = $watermark_image_id_object->value;
        }

        $watermark_image_location_object = DB::table('tl_uploaded_files')
            ->where('id', '=', $watermark_image_id)
            ->first();

        if ($watermark_image_location_object != null) {
            $watermark_image_location = $watermark_image_location_object->path;
        }



        if ($watermark_image_location != null && $watermark_image_id != null && $watermark_image_position != null && $watermark_image_opacity != null) {
            $watermark = Image::make('public/' . $watermark_image_location);
            $watermark->opacity((int)$watermark_image_opacity);
            $img->insert($watermark, $watermark_image_position);
            $img->save('public/' . $path);
        }



        $path = $data['folder_name'] . '/' . $data['image_name'] . $data['width'] . 'x' . $data['height'] . '.' . $data['extension'];
        $watermark = Image::make('public/' . $watermark_image_location);
        $watermark = $watermark->opacity((int)$watermark_image_opacity);
        $img = $img->insert($watermark, $watermark_image_position);
        $img->save('public/' . $path);
    }
}
