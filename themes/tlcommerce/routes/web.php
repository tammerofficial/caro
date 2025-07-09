<?php

use Core\Models\TlPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Core\Exceptions\ThemeRequiredPluginException;
use Theme\TLCommerce\Http\Controllers\Frontend\BlogController;
use Theme\TLCommerce\Http\Controllers\Backend\SliderController;
use Theme\TLCommerce\Http\Controllers\Backend\WidgetController;
use Theme\TLCommerce\Http\Controllers\Frontend\PagesController;
use Theme\TLCommerce\Http\Controllers\Backend\HomePageController;
use Theme\TLCommerce\Http\Controllers\Frontend\ProductController;
use Theme\TLCommerce\Http\Controllers\Backend\ThemeOptionController;

$prefix = Request::segment(1);

//Frontend 
if ($prefix == null || $prefix != getAdminPrefix()) {

    /**
     * Check required plugin is activated  or not
     */
    if (!isActivePluging('tlecommercecore')) {
        throw new ThemeRequiredPluginException('Please activate Tlcommerce plugin');
    }

    Route::get('/login', [PagesController::class, 'customerLogin']);
    Route::get('/register', [PagesController::class, 'customerRegistration']);

    Route::get('/products', [ProductController::class, 'allProductsPage']);
    Route::get('products/{id}', [ProductController::class, 'productDetails']);
    Route::get('deals/{id}', [ProductController::class, 'dealsPage']);
    Route::get('products/category/{id}', [ProductController::class, 'categoryProducts']);

    Route::get('/blog/{slug}', [BlogController::class, 'getSingleBlogDetails']);
    Route::get('/page/{any}', [PagesController::class, 'getSinglePageDetails'])->where('any', '.*');
    Route::get('/page-preview/{slug}', [PagesController::class, 'getSinglePageDetails']);

    Route::get('/seller-register', [PagesController::class, 'sellerRegistration']);
    Route::get('/all-shops', [PagesController::class, 'allShop']);
    Route::get('/shop/{slug}', [PagesController::class, 'shopPage']);

    Route::get('/{path}', function () {
        $page = TlPage::where('is_home', true)->first();
        return view('theme/tlcommerce::frontend.pages.home', compact('page'));
    })->where('path', '.*');
}


//Backend
Route::group(['middleware' => 'auth', 'prefix' => getAdminPrefix()], function () {
    Route::middleware(['can:Manage Slider Settings'])->group(function () {
        //Slider settings
        Route::get('sliders', [SliderController::class, 'sliders'])->name('theme.tlcommerce.sliders');
        Route::view('add-new-slider', 'theme/tlcommerce::backend.sliders.new')->name('theme.tlcommerce.sliders.new');
        Route::post('store-new-slider', [SliderController::class, 'storeNewSlider'])->name('theme.tlcommerce.sliders.new.store');
        Route::post('slider-delete', [SliderController::class, 'deleteSlider'])->name('theme.tlcommerce.sliders.delete');
        Route::post('update-slider-status', [SliderController::class, 'updateSliderStatus'])->name('theme.tlcommerce.sliders.update.status');
        Route::post('delete-bulk-slider', [SliderController::class, 'deleteBulkSlider'])->name('theme.tlcommerce.sliders.delete.bulk');
        Route::get('edit-slider/{id}', [SliderController::class, 'editSlider'])->name('theme.tlcommerce.sliders.edit');
        Route::post('update-slider', [SliderController::class, 'updateSlider'])->name('theme.tlcommerce.sliders.update');
    });

    Route::middleware(['can:Manage Home Page Builder'])->group(function () {
        //Home page builder
        Route::get('home-page-sections', [HomePageController::class, 'homePageSections'])->name('theme.tlcommerce.home.page.sections');
        Route::get('create-new-section', [HomePageController::class, 'newHomePageSection'])->name('theme.tlcommerce.home.page.sections.new');
        Route::post('sorting-sections', [HomePageController::class, 'sortingHomePageSection'])->name('theme.tlcommerce.home.page.sections.sorting');
        Route::post('remove-home-page-section', [HomePageController::class, 'removeHomePageSection'])->name('theme.tlcommerce.home.page.sections.remove');
        Route::post('update-home-page-section-status', [HomePageController::class, 'updateHomePageSectionStatus'])->name('theme.tlcommerce.home.page.sections.update.status');
        Route::post('get-layout-options', [HomePageController::class, 'layoutOptions'])->name('theme.tlcommerce.home.page.sections.layout.options');
        Route::post('get-ads-layout-options', [HomePageController::class, 'adsLayoutOptions'])->name('theme.tlcommerce.home.page.sections.ads.layout.options');
        Route::post('store-new-section', [HomePageController::class, 'storeNewHomePageSection'])->name('theme.tlcommerce.home.page.sections.new.store');
        Route::get('edit-home-page-section/{id}', [HomePageController::class, 'editHomePageSection'])->name('theme.tlcommerce.home.page.sections.edit');
        Route::post('update-home-section', [HomePageController::class, 'updateHomePageSection'])->name('theme.tlcommerce.home.page.sections.update');

        //builder
        Route::post('set-section-layout', [HomePageController::class, 'setSectionLayout'])->name('theme.tlcommerce.home.page.sections.layout.set');
        Route::post('load-element', [HomePageController::class, 'loadElements'])->name('theme.tlcommerce.home.page.sections.load.element');
    });

    // Widgets
    Route::middleware(['can:Manage Widget'])->group(function () {
        Route::get('/manage-widgets', [WidgetController::class, 'widgets'])->name('theme.tlcommerce.widgets');
        Route::post('/get-widget-input', [WidgetController::class, 'getWidgetInputFields'])->name('theme.tlcommerce.widget.get_input_field');
        Route::post('/add-widget-sidebar', [WidgetController::class, 'addWidgetToSidebar'])->name('theme.tlcommerce.widget.addToSidebar');
        Route::post('/remove-widget-sidebar', [WidgetController::class, 'removeWidgetFromSidebar'])->name('theme.tlcommerce.widget.removeFromSidebar');
        Route::post('/save-sidebar-widget-form', [WidgetController::class, 'saveWidgetSidebarInput'])->name('theme.tlcommerce.widget.widgetSidebarForm');
        Route::post('/widget-order-save', [WidgetController::class, 'saveWidgetOrder'])->name('theme.tlcommerce.widget.saveWidgetOrder');
    });


    Route::middleware(['can:Manage Theme General settings'])->group(function () {
        //Theme Options
        Route::get('/theme-options', [ThemeOptionController::class, 'themeOptions'])->name('theme.tlcommerce.options');
        Route::post('/get-theme-option-form', [ThemeOptionController::class, 'getOptionForm'])->name('theme.tlcommerce.get.option.form');
        Route::post('/save-theme-option-form', [ThemeOptionController::class, 'saveOptionForm'])->name('theme.tlcommerce.save.option.form');
    });
});
