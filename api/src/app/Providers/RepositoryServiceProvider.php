<?php

namespace App\Providers;

use App\Adapter\Gateway\QreChoiceRepository;
use App\Adapter\Gateway\QreVoteRepository;
use App\Adapter\Gateway\QuestionnaireRepository;
use App\Adapter\Gateway\TagRepository;
use App\Adapter\Gateway\UserRepository;
use Domain\Repository\QreChoiceRepositoryInterface;
use Domain\Repository\QreVoteRepositoryInterface;
use Domain\Repository\QuestionnaireRepositoryInterface;
use Domain\Repository\TagRepositoryInterface;
use Domain\Repository\UserRepositoryInterface;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(QuestionnaireRepositoryInterface::class, QuestionnaireRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(QreChoiceRepositoryInterface::class, QreChoiceRepository::class);
        $this->app->bind(QreVoteRepositoryInterface::class, QreVoteRepository::class);
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
