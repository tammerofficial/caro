<?php

namespace App\Http\Middleware;

use Closure;
use Core\Models\TlBlog;
use Core\Models\TlPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Plugin\TlcommerceCore\Models\Customers;
use Plugin\TlcommerceCore\Models\Product;

class CheckSubscriptionLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant_id = isTenant();

        if ($tenant_id) {
            $routeName = Route::currentRouteName();
            $package_privilege = $this->getPackagePrivilege();

            $folderPath = 'tenant/tenant' . $tenant_id;

            if ($routeName == "core.upload.media.file") {

                $files = $request->file('file');

                $totalSize = getTotalUsedSize($folderPath, $files);

                $allocated_storage = $package_privilege->package_privileges_allocated_storage;

                if ($allocated_storage != '-1') {
                    if ($totalSize >= intval($allocated_storage)) {
                        session()->put('storage_limit_over', 1);
                        return response()->json([
                            'success' => false,
                            'message' => translate("Your storage limit is over")
                        ], 500);
                    } else {
                        session()->put('storage_limit_over', 0);
                    }
                } else {
                    session()->put('storage_limit_over', 0);
                }
            }
            if ($routeName == "plugin.tlcommercecore.product.add.new" || $routeName == 'plugin.multivendor.seller.dashboard.products.add') {
                $total_product = Product::count();
                $total_product_creation = $package_privilege->package_privileges_create_product;

                if ($total_product_creation != '-1') {
                    if ($total_product >= intval($total_product_creation)) {
                        session()->put('product_limit_over', 1);
                        if ($routeName == "plugin.tlcommercecore.product.add.new") {
                            return redirect()->route('admin.dashboard');
                        } else {
                            toastNotification('error', translate('Your product upload limit is over, please contact with admin'));
                            return redirect()->route('plugin.multivendor.seller.dashboard');
                        }
                    } else {
                        session()->put('product_limit_over', 0);
                    }
                } else {
                    session()->put('storage_limit_over', 0);
                }
            }
            if ($routeName == "core.add.blog") {
                $total_blog = TlBlog::count();
                $total_blog_creation = $package_privilege->package_privileges_create_blog;
                if ($total_blog_creation != '-1') {
                    if ($total_blog >= intval($total_blog_creation)) {
                        session()->put('blog_limit_over', 1);
                        return redirect()->route('admin.dashboard');
                    } else {
                        session()->put('blog_limit_over', 0);
                    }
                } else {
                    session()->put('blog_limit_over', 0);
                }
            }
            if ($routeName == "core.page.add") {
                $total_page = TlPage::count();
                $total_page_creation = $package_privilege->package_privileges_create_page;

                if ($total_page_creation != '-1') {
                    if ($total_page >= intval($total_page_creation)) {
                        session()->put('page_limit_over', 1);
                        return redirect()->route('admin.dashboard');
                    } else {
                        session()->put('page_limit_over', 0);
                    }
                } else {
                    session()->put('page_limit_over', 0);
                }
            }
            if ($routeName == "plugin.tlcommercecore.customers.list") {
                $total_customers = Customers::count();
                $total_customers_creation = $package_privilege->package_privileges_customers;

                if ($total_customers_creation != '-1') {
                    if ($total_customers >= intval($total_customers_creation)) {
                        session()->put('customer_limit_over', 1);
                    } else {
                        session()->put('customer_limit_over', 0);
                    }
                } else {
                    session()->put('customer_limit_over', 0);
                }
            }
        }
        return $next($request);
    }

    /**
     * Get package Privilege
     */
    public function getPackagePrivilege()
    {
        $package_privilege = tenancy()->central(function ($tenant) {
            $request = app('request');
            $current_domain = clean_domain($request->getHost());
            $domain = DB::table('domains')->where('domain', '=', $current_domain)->first();
            $package_id = DB::table('tl_saas_accounts')->where('tenant_id', '=', $domain->tenant_id)
                ->value('package_id');
            $saas_account_id = DB::table('tl_saas_accounts')->where('tenant_id', '=', $domain->tenant_id)
                ->value('id');
            $package_privilege = DB::table('tl_saas_package_has_privileges')
                ->where('package_id', '=', $package_id)
                ->value('privileges');

            session()->put('saas_account_id', $saas_account_id);
            return json_decode($package_privilege);
        });

        return $package_privilege;
    }
}
