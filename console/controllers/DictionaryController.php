<?php

namespace console\controllers;

use common\models\Dictionary;
use Yii;
use yii\console\Controller;

class DictionaryController extends Controller
{
    public function actionGenerate()
    {
        mb_internal_encoding('utf-8');

        $words = [];
        $dir = new \DirectoryIterator(dirname(__FILE__) . '/../data/dict');
        foreach ($dir as $file) {
            if ($file->isDot()) {
                continue;
            }

            if (!preg_match_all('/^(\\p{L}{2,})\\s+\\d+\\s+(?:с|м|ж|мо|жо)\\s+/um',
                file_get_contents($file->getPathname()), $matches)
            ) {
                continue;
            }

            foreach ($matches[1] as $word) {
                if (mb_strlen($word) < 6 || mb_strlen($word) > 7) {
                    continue;
                }

                $words[] = $word;
            }
        }

        $words = array_unique($words);
        sort($words);
        foreach ($words as $name) {
            Yii::$app->db->createCommand()->insert(Dictionary::tableName(), ['name' => $name])->execute();
            echo $name . PHP_EOL;
        }
    }
}