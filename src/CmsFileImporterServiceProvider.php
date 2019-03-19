<?php

namespace Anacreation\CmsFileImporter;

use Anacreation\Cms\Models\Cms;
use Anacreation\CmsFileImporter\Models\FileImporter;
use Illuminate\Support\ServiceProvider;

class CmsFileImporterServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $this->views();

        $this->registerCmsPlugin();

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
        Cms::registerCmsPlugins(
            'CmsFileImporter',
            'CMS File Importer',
            'fileImporter');
        Cms::registerCmsPluginRoutes('CmsFileImporter', function () {
            FileImporter::routes();
        });
    }

}
