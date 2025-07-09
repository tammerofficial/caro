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
use Illuminate\Support\Facades\Log;
use Plugin\Saas\Models\SaasAccount;
use Plugin\Saas\Repositories\TenantRepository;

class TenantDatabaseMonitoringJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $repo, $saas_account_id, $package_id, $is_for_update, $database;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($saas_account_id, $package_id, $is_for_update)
    {
        $this->repo = new TenantRepository();
        $this->saas_account_id = $saas_account_id;
        $this->package_id = $package_id;
        $this->is_for_update = $is_for_update;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $saas_account = SaasAccount::find($this->saas_account_id);
        $tenant = Tenant::find($saas_account->tenant_id);
        $this->database = $tenant->tenancy_db_name;
        $tenantConfig = config('database.connections.tenant');
        $tenantConfig['database'] = $this->database;
        $tenantConfig['log'] = true;
        $tenantConnectionName = 'tenant_' . $this->database;
        config(["database.connections.$tenantConnectionName" => $tenantConfig]);
        session()->put('tenant_connection_name', $tenantConnectionName);
        $query = DB::connection($tenantConnectionName);
        $query->beginTransaction();

        try {
            if ($this->is_for_update == 0) {
                $this->repo->registerUserForNewStore($query, $saas_account);
                $this->repo->insertThirdPartyPluginTables($query);
                $this->repo->updateAllTenantPluginData($query, $this->package_id);
                $this->repo->updateAllTenantPaymentMethodData($query, $this->package_id);

                $saas_account->is_db_created = 1;
                $saas_account->is_db_updated = 1;
                $saas_account->status = 1;

                $saas_account->update();
            } else {
                $this->repo->updateAllTenantPluginData($query, $this->package_id);
                $this->repo->updateAllTenantPaymentMethodData($query, $this->package_id);
                $saas_account->is_db_updated = 1;
                $saas_account->status = 1;
                $saas_account->update();
            }
            $query->commit();
        } catch (\Exception $ex) {
            if ($this->is_for_update == 0) {
                $error = [
                    'message' => 'Error occurred during registering default user for tenant panel',
                    'data' => $saas_account,
                    'error' => $ex
                ];
                Log::channel('tenant_database')->info(json_encode($error));
            } else {
                $error = [
                    'message' => 'Error occurred during registering default user for tenant panel',
                    'data' => $saas_account,
                    'error' => $ex
                ];
                Log::channel('tenant_database')->info(json_encode($error));
            }
            $query->rollback();
        }
    }
}
