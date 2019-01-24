<?php
/**
 * Author: Xavier Au
 * Date: 2019-01-24
 * Time: 14:00
 */

namespace Anacreation\CmsFileImporter\Controllers;


use Anacreation\Cms\Models\Page;
use Anacreation\Cms\Services\ContentService;
use Illuminate\Http\Request;

class FileImportersController
{
    public function index(Request $request) {
        $pages = Page::pluck('uri', 'id');

        $service = new ContentService;

        $types = $service->getTypes();

        return view('cms:fileImporter::index', compact('pages', 'types'));
    }
}