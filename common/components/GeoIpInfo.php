<?php

namespace common\components;

use Yii;

class GeoIpInfo
{
    public $_ipAddress;
    public $_charset = 'utf-8';

    /**
     * @param null $options
     */
    public function __construct($options = null)
    {
        if (isset($options['ipAddress']) && $this->_isValidIp($options['ipAddress'])) {
            $this->_ipAddress = $options['ipAddress'];
        } else {
            $this->_ipAddress = $this->_getIp();
        }

        if (isset($options['charset']) && is_string($options['charset']) && $options['charset'] != 'windows-1251') {
            $this->_charset = $options['charset'];
        }
    }

    /**
     * @param null $ip
     *
     * @return bool
     */
    private function _isValidIp($ip = null)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    private function _getIp()
    {
        $keys = array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR', 'HTTP_X_REAL_IP');
        foreach ($keys as $key) {
            $ip = trim(strtok(filter_input(INPUT_SERVER, $key), ','));
            if ($this->_isValidIp($ip)) {
                return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
            }
        }

        return null;
    }

    /**
     * @param null      $key
     * @param bool|true $cookie
     *
     * @return array|null|string
     */
    public function getValue($key = null, $cookie = true)
    {
        $keys = array('inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng');
        if (!in_array($key, $keys)) {
            $key = null;
        }

        $data = $this->_getData($cookie);
        if (!$key) {
            return $data;
        }

        if (isset($data[$key])) {
            return $data[$key];

        } elseif ($cookie) {
            return $this->getValue($key, false);
        }

        return 'не определен';
    }

    /**
     * Получаем данные с сервера или из cookie
     *
     * @param boolean $cookie
     *
     * @return string|array
     */
    private function _getData($cookie = true)
    {
        if ($cookie && filter_input(INPUT_COOKIE, 'geobase')) {
            return unserialize(filter_input(INPUT_COOKIE, 'geobase'));
        }

        $data = $this->_getGeoBaseData();
        if (!empty($data)) {
            setcookie('geobase', serialize($data), time() + 3600 * 24 * 7, '/');
        }

        return $data;
    }

    /**
     * @return array
     */
    private function _getGeoBaseData()
    {
        $ch = curl_init('http://ipgeobase.ru:7020/geo?ip=' . $this->_ipAddress);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $string = curl_exec($ch);

        if ($this->_charset != 'windows-1251' && function_exists('iconv')) {
            $string = iconv('windows-1251', $this->_charset, $string);
        }

        return $this->_parseString($string);
    }

    /**
     * @param $string
     *
     * @return array
     */
    private function _parseString($string)
    {
        $params = array('inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng');
        $data = $out = array();
        foreach ($params as $param) {
            if (preg_match('#<' . $param . '>(.*)</' . $param . '>#is', $string, $out)) {
                $data[$param] = trim($out[1]);
            }
        }

        return $data;
    }
}