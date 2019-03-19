<?php
/**
 * Author: Xavier Au
 * Date: 2019-01-24
 * Time: 14:00
 */

namespace Anacreation\CmsFileImporter\Controllers;


use Anacreation\Cms\Entities\ContentObject;
use Anacreation\Cms\Models\Language;
use Anacreation\Cms\Models\Page;
use Anacreation\Cms\Services\ContentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class FileImportersController extends Controller
{
    public function index(Request $request, ContentService $service) {
        $pages = Page::pluck('uri', 'id');

        $types = $service->getTypesForJs();
        $langCodes = Language::whereIsActive(true)->pluck('code')->toArray();

        return view('cms:fileImporter::index',
            compact('pages', 'types', 'langCodes'));
    }

    /**
     * @param \Illuminate\Http\Request                 $request
     * @param \Anacreation\Cms\Services\ContentService $service
     * @return mixed
     * @throws \Anacreation\Cms\Exceptions\IncorrectContentTypeException
     */
    public function load(Request $request, ContentService $service) {

        $this->validate($request, [
            'path'         => 'required',
            'identifier'   => 'required',
            'page_id'      => 'required|exists:pages,id',
            'lang_code'    => 'required|exists:languages,code',
            'content_type' => 'required|in:' . implode(',',
                    array_keys($service->getTypesForJs())),
        ]);

        $this->execute($request, $service);

        return redirect()->route('cms:plugins:fileImporters.index')
                         ->withStatus('Loaded!');
    }

    /**
     * @param \Illuminate\Http\Request                 $request
     * @param \Anacreation\Cms\Services\ContentService $service
     * @throws \Anacreation\Cms\Exceptions\IncorrectContentTypeException
     */
    private function execute(Request $request, ContentService $service) {

        $language = Language::whereCode($request->get('lang_code'))->first();

        $files = File::files($request->get('path'));
        
        //        $files = File::files(storage_path('app/' . $request->get('path')));
        $page = Page::find($request->get('page_id'));

        /** @var \SplFileInfo $file */
        foreach ($files as $index => $file) {
            $path = $file->getPath() . "/" . $file->getFilename();

            $uploadFile = new UploadedFile($path,
                $file->getFilename());

            $contentObject = new ContentObject(
                $request->get('identifier') . ($index + 1),
                $language->id,
                "",
                $request->get('content_type'),
                $uploadFile);

            $service->updateOrCreateContentIndexWithContentObject($page,
                $contentObject);
        }
    }
}