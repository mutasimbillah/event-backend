<?php

namespace App\Providers;

use App\Enums\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->isLocal() && DB::enableQueryLog();

        Blueprint::macro('status', function ($column = 'status') {
            return $this->unsignedTinyInteger($column)->default(Status::ACTIVE);
        });
    }
}
