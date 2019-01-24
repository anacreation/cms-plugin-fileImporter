<?php
/**
 * Author: Xavier Au
 * Date: 14/4/2018
 * Time: 6:48 PM
 */

namespace Anacreation\CmsFileImporter\Models;


use Anacreation\CmsFileImporter\Controllers\FileImportersController;
use Illuminate\Support\Facades\Route;

class FileImporter
{
    public static function routes(): void {

        Route::group(['prefix' => config('admin.route_prefix')],
            function () {
                Route::group([
                    'middleware' => ['auth:admin', 'web'],
                    'prefix'     => 'fileImporter'
                ],
                    function () {
                        Route::get('/',
                            FileImportersController::class . "@index")
                             ->name('cms:plugins:fileImporters.index');
                    });

            });
    }
}