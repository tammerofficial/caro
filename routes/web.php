<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route for testing CSS - bypassing install middleware
Route::get('/test-css', function () {
    return view('test');
})->name('test.css')->withoutMiddleware(['install']);

// Route for direct CSS test without any middleware
Route::get('/css-test', function () {
    return view('test');
})->name('css.test.direct');

// CSS Demo Route - completely bypassing all middleware
Route::get('/css-demo', function () {
    return view('test');
});

// Default route - bypassing all middleware
Route::get('/', function () {
    try {
        // Get the active theme
        $activeTheme = getActiveTheme();
        
        // Get home page data
        $homePage = \Core\Models\TlPage::where('is_home', true)->first();
        
        if (!$homePage) {
            return response()->json(['error' => 'Home page not found'], 404);
        }
        
        // Try to render the theme view
        $viewPath = "frontend.pages.home";
        
        if (!view()->exists($viewPath)) {
            return response()->json(['error' => "View {$viewPath} not found"], 404);
        }
        
        return view($viewPath, [
            'page' => $homePage,
            'theme' => $activeTheme,
            'page_sections' => [] // متغير وهمي لتجربة العرض
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->withoutMiddleware(['install', 'SystemInstalled']);

// Test route for theme home page
Route::get('/theme-home', function () {
    try {
        // Get the active theme
        $activeTheme = getActiveTheme();
        
        // Get home page data
        $homePage = \Core\Models\TlPage::where('is_home', true)->first();
        
        if (!$homePage) {
            return response()->json(['error' => 'Home page not found'], 404);
        }
        
        return response()->json([
            'theme' => $activeTheme->location,
            'home_page' => $homePage->title,
            'status' => 'success'
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->withoutMiddleware(['install', 'SystemInstalled']);

// Test route for theme view
Route::get('/theme-view', function () {
    try {
        // Get the active theme
        $activeTheme = getActiveTheme();
        
        // Get home page data
        $homePage = \Core\Models\TlPage::where('is_home', true)->first();
        
        if (!$homePage) {
            return response()->json(['error' => 'Home page not found'], 404);
        }
        
        // Try to render the theme view
        $viewPath = "frontend.pages.home";
        
        if (!view()->exists($viewPath)) {
            return response()->json(['error' => "View {$viewPath} not found"], 404);
        }
        
        return view($viewPath, [
            'page' => $homePage,
            'theme' => $activeTheme,
            'page_sections' => [] // متغير وهمي لتجربة العرض
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->withoutMiddleware(['install', 'SystemInstalled']);

// Simple test route
Route::get('/simple', function () {
    return '<h1>Hello World! Laravel is working!</h1>';
})->withoutMiddleware(['install', 'SystemInstalled']);

// CSS files route
Route::get('/themes/{theme}/public/assets/css/{file}', function ($theme, $file) {
    $path = base_path("themes/{$theme}/public/assets/css/{$file}");
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'text/css']);
    }
    abort(404);
})->withoutMiddleware(['install', 'SystemInstalled']);

// JS files route
Route::get('/themes/{theme}/public/assets/js/{file}', function ($theme, $file) {
    $path = base_path("themes/{$theme}/public/assets/js/{$file}");
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'application/javascript']);
    }
    abort(404);
})->withoutMiddleware(['install', 'SystemInstalled']);

// Images and other assets route
Route::get('/themes/{theme}/public/assets/{type}/{file}', function ($theme, $type, $file) {
    $path = base_path("themes/{$theme}/public/assets/{$type}/{$file}");
    if (file_exists($path)) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $contentType = 'application/octet-stream';
        
        if (in_array($extension, ['jpg', 'jpeg'])) {
            $contentType = 'image/jpeg';
        } elseif ($extension === 'png') {
            $contentType = 'image/png';
        } elseif ($extension === 'gif') {
            $contentType = 'image/gif';
        } elseif ($extension === 'svg') {
            $contentType = 'image/svg+xml';
        } elseif ($extension === 'ico') {
            $contentType = 'image/x-icon';
        }
        
        return response()->file($path, ['Content-Type' => $contentType]);
    }
    abort(404);
})->withoutMiddleware(['install', 'SystemInstalled']);