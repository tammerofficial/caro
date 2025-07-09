<?php

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Core\Models\TlBlog;
use Core\Models\TlPage;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SiteMapController extends Controller
{
    /**
     * Will return to site map page
     */
    public function sitemap(): View
    {
        return view('core::base.system.sitemap.index');
    }
    /**
     * Will Generate tenant Sitemap
     */
    public function generateTenantSitemap(Request $request): JsonResponse
    {
        try {
            $path = public_path(isTenant() . '_sitemap.xml');
            $blogs = TlBlog::where('is_publish', config('settings.general_status.active'))
                ->select('id', 'permalink')
                ->get();

            $pages = TlPage::where('publish_status', config('settings.general_status.active'))
                ->select('id', 'permalink')
                ->get();


            $site_map = Sitemap::create()
                ->add(Url::create('/')
                    ->setPriority(0.1))

                ->add(Url::create('/login')
                    ->setPriority(0.1))

                ->add(Url::create('/register')
                    ->setPriority(0.1))

                ->add(Url::create('/products')
                    ->setPriority(0.1))

                ->add(Url::create('/blogs')
                    ->setPriority(0.1))

                ->add($blogs)
                ->add($pages);

            //Ecommerce link
            if (isActivePluging('tlecommercecore')) {
                $products = \Plugin\TlcommerceCore\Models\Product::where('status', config('settings.general_status.active'))
                    ->select('id', 'permalink')
                    ->get();
                $product_categories = \Plugin\TlcommerceCore\Models\ProductCategory::where('status', config('settings.general_status.active'))
                    ->select('id', 'permalink')
                    ->get();

                $fash_deals = \Plugin\Flashdeal\Models\FlashDeal::where('status', config('settings.general_status.active'))
                    ->select('id', 'permalink')
                    ->get();

                $site_map->add($products)
                    ->add($product_categories)
                    ->add($fash_deals);
            }


            //Multivendor links
            if (isActivePluging('multivendor')) {
                $all_shop = \Plugin\Multivendor\Models\SellerShop::where('status', config('settings.general_status.active'))
                    ->select('id', 'shop_slug')
                    ->get();

                $site_map->add(Url::create('/seller-register')
                    ->setPriority(0.1))

                    ->add(Url::create('/seller/login')
                        ->setPriority(0.1))

                    ->add(Url::create('/all-shops')
                        ->setPriority(0.1))

                    ->add($all_shop);
            }

            $site_map->writeToFile($path);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
    /**
     * Will download tenant sitemap 
     */
    public function downloadTenantSitemap(): BinaryFileResponse
    {
        $filename = isTenant() . '_sitemap.xml';
        $path = public_path($filename);

        if (!file_exists(public_path($filename))) {
            abort(404);
        }

        return response()->download($path, $filename);
    }

    /**
     * Will download sitemap
     */
    public function downloadSitemap(): BinaryFileResponse
    {
        $filename = 'sitemap.xml';
        $path = public_path($filename);

        if (!file_exists(public_path($filename))) {
            abort(404);
        }

        return response()->download($path, $filename);
    }

    /**
     * Will Generate Sitemap
     */
    public function generateSitemap(Request $request): JsonResponse
    {
        try {
            $path = public_path('sitemap.xml');
            $blogs = TlBlog::where('is_publish', config('settings.general_status.active'))
                ->select('id', 'permalink')
                ->get();

            $pages = TlPage::where('publish_status', config('settings.general_status.active'))
                ->select('id', 'permalink')
                ->get();


            $site_map = Sitemap::create()
                ->add(Url::create('/')
                    ->setPriority(0.1))

                ->add(Url::create('/user/login')
                    ->setPriority(0.1))

                ->add(Url::create('/user/registration')
                    ->setPriority(0.1))

                ->add($blogs)
                ->add($pages);

            $site_map->writeToFile($path);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
