<?php

namespace Anacreation\CmsFileImporter;

use Anacreation\Cms\Models\Cms;
use Anacreation\CmsEmail\Commands\EmailCommand;
use Anacreation\CmsEmail\Models\FileImporter;
use Anacreation\Notification\Provider\Contracts\EmailSender;
use Anacreation\Notification\Provider\ServiceProviders\SendGrid;
use Illuminate\Support\ServiceProvider;

class CmsFileImporterServiceProvider extends ServiceProvider
{
    protected $commands = [
        EmailCommand::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->views();

        $this->registerCmsPlugin();

        app()->bind(EmailSender::class, SendGrid::class);

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

    }

    private function views() {
        $this->loadViewsFrom(__DIR__ . '/views', 'cms:fileImporter');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/cms:fileImporter'),
        ], 'cms:fileImporter');

    }

    private function registerCmsPlugin(): void {
        Cms::registerCmsPlugins('CmsFileImporter', 'FileImporter',
            'fileImporter');
        Cms::registerCmsPluginRoutes('CmsFileImporter', function () {
            FileImporter::routes();
        });
    }

}
