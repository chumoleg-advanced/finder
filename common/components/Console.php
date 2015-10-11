<?php

namespace common\components;

class Console
{
    /**
     * @param string $commandString
     */
    public static function start($commandString)
    {
        if (empty($commandString)) {
            return;
        }

        $command = PHP_BINDIR . '/php ./yii ' . $commandString . ' 2>&1';
        $handle = popen($command, 'r');
        while (!feof($handle)) {
            echo fread($handle, 2096);
        }
        pclose($handle);
    }
}