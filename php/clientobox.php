<?php

/**
 * Class Clientobox
 *
 * Dependencies: CURL, json, php>=5.4
 */
class Clientobox
{
    protected $_apiKey = null;
    protected $_clientoBoxUrl = 'https://app.clientobox.ru';
    protected $_maxTimeout = 300;

    /**
     * Set api key on object construct
     *
     * @param string $apiKey
     * @throws Exception
     */
    function __construct($apiKey)
    {
        if (empty($apiKey)) {
            throw new Exception("API key is empty!");
        }
        $this->_apiKey = urlencode($apiKey);
    }

    /**
     * Request data from API
     *
     * @param $controller
     * @param $method
     * @param array $parameters
     * @throws Exception
     * @return string|array
     */
    function exec($controller, $method, array $parameters = array())
    {
        $url = $this->_clientoBoxUrl . "/api/" . urlencode($controller) . "/" . urlencode($method);
        $parameters['api_key'] = $this->_apiKey;
        $data = json_decode($this->_request($url, $parameters), true);
        if (isset($data['error'])) {
            throw new Exception($data['error']);
        }
        return $data;
    }

    protected function _request($url, array $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_maxTimeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($ch);
        curl_close($ch);
        return $out;
    }
}