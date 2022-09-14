<?php

namespace App\Http\Controllers\Admin\Translations;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsLanguages;
use Carbon\Carbon;

class TransferDataController extends Controller
{
    public function handle(String $mode, Request $request)
    {
        if ($mode == 'export') {
            return $this->exportTranslations($request);
        } else if ($mode == 'import') {
            if (!$request->isMethod('post')) {
                return redirect()->route('admin.translation.transfer_data', ['mode' => 'add_import']);
            }
            return $this->importTranslations($request);
        } else if ($mode == 'add_import') {
            $errors = session()->get('errors');
            $errorMessage = $errors ? $errors->first('import_file') : '';

            echo '
           <form action="' . route('admin.translation.transfer_data', ['mode' => 'import']) . '" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="' . csrf_token() . '" />
            <input type="file" name="import_file" required2 accept="application/JSON">
            <button>Import</button>
            <br /><span style="color:red;">' . $errorMessage . '</span>
           </form>';
            exit;
        }
        abort(404);
    }

    private function exportTranslations(Request $request)
    {
        $params = $request->all();
        $translations = $this->repository
            ->search(0, $params, false)
            ->toJson();

        $fileName = 'translations-' . time() . '.json';
        $headers = [
            //"Content-type" => "text/csv",
            "Content-type" => "application/json",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($translations) {
            $file = fopen('php://output', 'w');
            fputs($file, $translations);
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers)->send();
    }

    private function importTranslations(Request $request)
    {
        $this->validate($request, [
            // check validtion for json 
            'import_file' => 'required|file' // mimetypes:application/json // not working
        ]);

        if (!$request->hasFile('import_file')) {
            die('No file found');
        }
        $file = $request->file('import_file');

        $contents = file_get_contents($file->getRealPath());
        $translations = json_decode($contents, true);

        if (is_null($translations)) {
            return redirect()->route('admin.translation.transfer_data', ['mode' => 'add_import'])
            ->withErrors(['import_file' => ['Invalid file type.']]);
        }

        $createdCount = 0;
        $updatedCount = 0;
        foreach ($translations as $k => $data) {
            unset($data['id']);
            $row = $this->repository->findBy([
                'group' => $data['group'],
                'key' => $data['key'],
            ]);
            if ($row) {
                $importDate = Carbon::parse($data['updated_at']);
                $rowDate = Carbon::parse($row->updated_at);
                if ($importDate->gt($rowDate)) {

                    $res = $this->repository->store($data, $row);
                    if ($res) {
                        ++$updatedCount;
                    }
                }
            } else {
                $res = $this->repository->store($data);
                if ($res) {
                    ++$createdCount;
                }
            }
        }

        echo '
        Added : ' . $createdCount . '<br />
        Updated : ' . $updatedCount . '<br />
        <a href="' . route('admin.translation.transfer_data', ['mode' => 'add_import']) . '">Back</a>
        ';
        exit;
    }
}
