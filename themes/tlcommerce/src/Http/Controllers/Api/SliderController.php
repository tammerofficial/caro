<?php

namespace Theme\TLCommerce\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Theme\TLCommerce\Models\Sliders;
use Illuminate\Support\Facades\Cache;
use Theme\TLCommerce\Http\Resources\SliderResource;

class SliderController extends Controller
{
    /**
     * Will return active sliders
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sliders()
    {
        return Cache::rememberForever('home-page-sliders-resource', function () {
            return new SliderResource(Sliders::select('url', 'desktop', 'mobile')->where('status', config('settings.general_status.active'))->get());
        });
    }
}
