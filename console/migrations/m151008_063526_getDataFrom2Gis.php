<?php

use console\components\Migration;

class m151008_063526_getDataFrom2Gis extends Migration
{
    public function up()
    {
//        $url
//            = 'http://catalog.api.2gis.ru/2.0/catalog/rubric/list?parent_id=0&region_id=1&sort=popularity&fields=items.rubrics&key=rusazx2220';
//        $dataFrom2Gis = Yii::$app->curl->get($url);
//        $data = \yii\helpers\Json::decode($dataFrom2Gis);
//        if (empty($data['result']['items'])) {
//            echo 'Empty data from 2Gis!!!!' . PHP_EOL;
//            die;
//        }

        $this->createTable('category', [
            'id'          => self::PRIMARY_KEY,
            'name'        => 'VARCHAR(200) NOT NULL',
            'date_create' => self::DATE_FIELD,
        ], self::TABLE_OPTIONS);

        $this->createTable('rubric', [
            'id'          => self::PRIMARY_KEY,
            'category_id' => self::INT_FIELD . ' NOT NULL',
            'name'        => 'VARCHAR(250) NOT NULL',
            'date_create' => self::DATE_FIELD,
        ], self::TABLE_OPTIONS);

        $this->addForeignKey('fk_rubric_category_id', 'rubric', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');

//        $this->_insertDataFrom2Gis($data);
    }

    public function down()
    {
        $this->dropForeignKey('fk_rubric_category_id', 'rubric');
        $this->dropTable('rubric');
        $this->dropTable('category');
    }

    /**
     * @param $data
     *
     * @throws \yii\db\Exception
     */
    private function _insertDataFrom2Gis($data)
    {
        $date = date('Y-m-d H:i:s');
        $connect = Yii::$app->db;
        foreach ($data['result']['items'] as $mainCategory) {
            echo $mainCategory['name'] . PHP_EOL;
            $connect->createCommand()
                ->insert('category', [
                    'name'        => $mainCategory['name'],
                    'date_create' => $date
                ])
                ->execute();

            $categoryId = $connect->getLastInsertID();
            foreach ($mainCategory['rubrics'] as $rubric) {
                $connect->createCommand()
                    ->insert('rubric', [
                        'category_id' => $categoryId,
                        'name'        => $rubric['name'],
                        'date_create' => $date
                    ])
                    ->execute();
            }
        }
    }
}
