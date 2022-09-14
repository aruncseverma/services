<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Repository\TranslationRepository;

class TranslationsTableSeeder extends Seeder
{
    private $repo;

    public function __construct(TranslationRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get all translations from php file
        $groupTrans = $this->getPhpLanguagesByGroupsKeys();
        foreach($groupTrans as $groupName => $trans) {
            foreach($trans as $key => $text) {
                $data = [
                    'group' => $groupName,
                    'key' => $key,
                ];
                $model = $this->repo->findBy($data);
                $data['text'] = $text;
                $this->repo->store($data, $model);
            }
        }

        // get all translations from json file
        $trans = $this->getJsonLanguages();
        if (!empty($trans)) {
            foreach($trans as $key => $text) {
                $data = [
                    'group' => '*',
                    'key' => $key,
                ];
                $model = $this->repo->findBy($data);
                $data['text'] = $text;
                $this->repo->store($data, $model);
            }
        }
    }

    /**
     * Get translations from json file
     * 
     * @return array
     */
    protected function getJsonLanguages()
    {
        $directoryPath = resource_path("lang");
        $files = File::files($directoryPath);
        $trans = [];
        foreach($files as $file) {
            $langCode = basename($file->getFileName(), '.json');
            if ($file->getExtension() === 'json') {
                $langTrans = json_decode(file_get_contents($file->getPathname()), true);
                foreach($langTrans as $key => $value) {
                    if (!isset($trans[$key])) {
                        $trans[$key] = [];
                    }
                    $trans[$key][$langCode] = $value;
                }
            }
        }
        return $trans;
    }

    /**
     * Get translations from php file
     * 
     * @return array
     */
    protected function getPhpLanguagesByGroupsKeys()
    {
        $directoryPath = resource_path("lang");

        $languages = File::directories($directoryPath);
        $groups = [];
        foreach ($languages as $langPath) {
            $langCode = basename($langPath);
            $files = File::files($langPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    $groupName = basename($file->getFileName(), '.php');
                    $trans = File::getRequire($file->getPathname());
                    if (!isset($groups[$groupName])) {
                        $groups[$groupName] = [];
                    }
                    $groups = $this->getGroupsKeysData($groups, $groupName, $langCode, $trans);
                }
            }
        }

        return $groups;
    }

    /**
     * group translations to group name and key
     * 
     * @return array
     */
    protected function getGroupsKeysData($groups, $groupName, $langCode, $trans, $parentKey = null)
    {
        foreach ($trans as $key => $value) {
            if (!empty($parentKey)) {
                $key = $parentKey . '.' . $key;
            }
            if (is_array($value)) {
                $groups = $this->getGroupsKeysData($groups, $groupName, $langCode, $value, $key);
            } else {
                if (!isset($groups[$groupName][$key])) {
                    $groups[$groupName][$key] = [];
                }
                $groups[$groupName][$key][$langCode] = $value;
            }
        }

        return $groups;
    }
}
