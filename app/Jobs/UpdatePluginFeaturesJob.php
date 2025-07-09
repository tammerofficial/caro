<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Plugin\Saas\Repositories\TenantRepository;

class UpdatePluginFeaturesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tenantId;
    public $package_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tenantId, $package_id)
    {
        $this->tenantId = $tenantId;
        $this->package_id = $package_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tenant = Tenant::find($this->tenantId);
        $database = $tenant->tenancy_db_name;

        $tenantConfig = config('database.connections.tenant');
        $tenantConfig['database'] = $database;
        $tenantConnectionName = 'tenant_' . $database;
        config(["database.connections.$tenantConnectionName" => $tenantConfig]);
        $query = DB::connection($tenantConnectionName);

        $repository = new TenantRepository();

        $repository->updateAllTenantPluginData($query, $this->package_id);
        $repository->updateAllTenantPaymentMethodData($query, $this->package_id);

        DB::table('tl_saas_accounts')
            ->where('tenant_id', $this->tenantId)
            ->update(['is_db_updated' => 1]);
    }
}
