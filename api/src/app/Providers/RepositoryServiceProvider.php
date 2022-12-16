<?php

namespace App\Providers;

use App\Adapter\Gateway\QuestionnaireRepository;
use Domain\Repository\QuestionnaireRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * RepositoryServiceProvider class
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any Repository services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QuestionnaireRepositoryInterface::class, QuestionnaireRepository::class);
    }

    /**
     * Bootstrap any Repository services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
