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

class UpdateTenantDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tenantId;
    public $sql;
    public $is_for_plugin;
    public $plugin_location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tenantId, $sql, $is_for_plugin, $plugin_location = '')
    {
        $this->tenantId = $tenantId;
        $this->sql = $sql;
        $this->is_for_plugin = $is_for_plugin;
        $this->plugin_location = $plugin_location;
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
        try {
            if ($this->is_for_plugin) {
                $query->unprepared($this->sql);
                $failed_plugins = DB::table('tl_saas_plugin_install_failed')
                    ->where('tenant_id', '=', $this->tenantId);

                $total_failed_plugin = $failed_plugins->count();

                $is_deleted = $failed_plugins->where('plugin_location', '=', $this->plugin_location)->delete();

                if ($total_failed_plugin == 0 || ($total_failed_plugin == 1 && $is_deleted == 1)) {
                    DB::table('tl_saas_accounts')
                        ->where('tenant_id', '=', $this->tenantId)
                        ->update(['is_plugin_db_updated' => 1, 'status' => 1]);
                }
            } else {
                foreach ($this->sql as $sql) {
                    $root_path = storage_path('app/tempUpdate');
                    $sql_path = $root_path . '/' . $sql['path'];
                    if (file_exists($sql_path)) {
                        $sql_file = file_get_contents($sql_path);
                        if ($sql['type'] == 'tenant' || $sql['type'] == 'both') {
                            $query->unprepared($sql_file);
                        }
                    }
                }

                DB::table('tl_saas_accounts')
                    ->where('tenant_id', '=', $this->tenantId)
                    ->update(['is_system_db_updated' => 1, 'status' => 1]);
            }
        } catch (\Exception $ex) {
            $error = [
                'message' => 'Error occurred during updateTenantDatabaseJob',
                'data' => $tenant,
                'error' => $ex
            ];
            Log::channel('tenant_database')->info(json_encode($error));

            if ($this->is_for_plugin) {
                $existingRecord = DB::table('tl_saas_plugin_install_failed')
                    ->where('tenant_id', $this->tenantId)
                    ->where('plugin_location', $this->plugin_location)
                    ->first();

                if (!$existingRecord) {
                    DB::table('tl_saas_plugin_install_failed')->insert([
                        'tenant_id' => $this->tenantId,
                        'plugin_location' => $this->plugin_location,
                    ]);
                }
            }
        }
    }
}
