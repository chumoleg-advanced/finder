<?php

use console\components\Migration;
use \yii\base\Exception;

class m151102_142433_migrateFromFiles extends Migration
{
    public function up()
    {
        try {
            $this->createTable('auto_part', [
                'id'          => self::PRIMARY_KEY,
                'name'        => 'VARCHAR(150)',
                'date_create' => self::DATE_FIELD
            ], self::TABLE_OPTIONS);

            $this->createTable('manufacturer', [
                'id'          => self::PRIMARY_KEY,
                'name'        => 'VARCHAR(150)',
                'type'        => 'TINYINT(2) UNSIGNED NOT NULL',
                'date_create' => self::DATE_FIELD
            ], self::TABLE_OPTIONS);

            $this->createTable('wheel_param', [
                'id'          => self::PRIMARY_KEY,
                'type'        => 'TINYINT(2) UNSIGNED NOT NULL',
                'value'       => 'VARCHAR(50) NOT NULL',
                'date_create' => self::DATE_FIELD
            ], self::TABLE_OPTIONS);
        } catch (Exception $e) {
        }

        $this->_insertAutoParts();
        $this->_insertTiresFirm();
        $this->_insertWheelDiskFirm();
        $this->_insertWheelParams();
    }

    public function down()
    {
        try {
            $this->dropTable('auto_part');
            $this->dropTable('manufacturer');
            $this->dropTable('wheel_param');
        } catch (Exception $e) {
        }
    }

    private function _insertAutoParts()
    {
        $file = 'autoPart.csv';
        $autoParts = $this->_getDataFromFile(Yii::$app->getBasePath() . '/data/' . $file);

        $insertData = [];
        foreach ($autoParts as $item) {
            if (!empty($item[0])) {
                $name = str_replace('"', '', $item[0]);
                $insertData[] = '("' . implode('", "', [$name, date('Y-m-d H:i:s')]) . '")';
            }
        }

        $this->execute('INSERT INTO auto_part (name, date_create) VALUES '
            . implode(', ', $insertData));
    }

    private function _insertTiresFirm()
    {
        $file = 'tireFirm.csv';
        $tireFirm = $this->_getDataFromFile(Yii::$app->getBasePath() . '/data/' . $file);

        $insertData = [];
        foreach ($tireFirm as $item) {
            if (!empty($item[0])) {
                $insertData[] = '("' . implode('", "', [$item[0], 1, date('Y-m-d H:i:s')]) . '")';
            }
        }

        $this->execute('INSERT INTO manufacturer (name, type, date_create) VALUES '
            . implode(', ', $insertData));
    }

    private function _insertWheelDiskFirm()
    {
        $file = 'wheelDiskFirm.csv';
        $diskFirm = $this->_getDataFromFile(Yii::$app->getBasePath() . '/data/' . $file);

        $insertData = [];
        foreach ($diskFirm as $item) {
            if (!empty($item[0])) {
                $insertData[] = '("' . implode('", "', [$item[0], 2, date('Y-m-d H:i:s')]) . '")';
            }
        }

        $this->execute('INSERT INTO manufacturer (name, type, date_create) VALUES '
            . implode(', ', $insertData));
    }

    private function _insertWheelParams()
    {
        $file = 'wheelParams.csv';
        $wheelParam = $this->_getDataFromFile(Yii::$app->getBasePath() . '/data/' . $file);
        unset($wheelParam[0]);

        $insertData = [];
        foreach ($wheelParam as $item) {
            foreach ($item as $k => $v) {
                if (empty($v)) {
                    continue;
                }

                $type = $k + 1;
                $v = str_replace('"', '', $v);
                $insertData[] = '("' . implode('", "', [$type, $v, date('Y-m-d H:i:s')]) . '")';
            }
        }

        $this->execute('INSERT INTO wheel_param (type, value, date_create) VALUES '
            . implode(', ', $insertData));
    }

    /**
     * @param string $filename
     *
     * @return array
     */
    private function _getDataFromFile($filename)
    {
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data[] = $row;
            }

            fclose($handle);
        }

        return $data;
    }
}
