<?php
/**
 * Author: Xavier Au
 * Date: 2019-01-24
 * Time: 14:00
 */

namespace Anacreation\CmsFileImporter\Controllers;


use Anacreation\Cms\Models\Language;
use Anacreation\Cms\Models\Page;
use Anacreation\Cms\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileImportersController
{
    public function index(Request $request, ContentService $service) {
        $pages = Page::pluck('uri', 'id');

        $types = $service->getTypesForJs();

        return view('cms:fileImporter::index', compact('pages', 'types'));
    }

    public function load(Request $request, ContentService $service) {

        $this->validate($request, [
            'path'         => 'required',
            'identifier'   => 'required',
            'page_id'      => 'required|exists:pages,id',
            'content_type' => 'required|in:' . implode(',',
                    $service->getTypesForJs()),
        ]);

        return redirect()->route('cms:plugins:fileImporters.index')
                         ->withStatus('Loaded!');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @throws \Anacreation\Cms\Exceptions\IncorrectContentTypeException
     */
    private function execute(Request $request) {
        $service = new \Anacreation\Cms\Services\ContentService();

        $language = Language::whereCode('en')->first();

        $files = File::files(storage_path('app/temp'));
        $page = Page::whereUri($request->get('uri'))->first();

        /** @var \SplFileInfo $file */
        foreach ($files as $index => $file) {
            $path = $file->getPath() . "/" . $file->getFilename();

            $uploadFile = new \Illuminate\Http\UploadedFile($path,
                $file->getFilename());

            $contentObject = new \Anacreation\Cms\Entities\ContentObject("image_" . ($index + 1),
                $language->id, "", 'scaledImage', $uploadFile);

            $service->updateOrCreateContentIndexWithContentObject($page,
                $contentObject);
        }
    }
}