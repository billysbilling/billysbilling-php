<?php
class Billy_Client {

    private $apiKey;
    private $apiVersion;

    /**
     * Construct a Billy Client with a valid API key and optionally an API version.
     *
     * @param string $apiKey API key from Billy
     * @param string $apiVersion Optional (currently v1)
     */
    public function __construct($apiKey, $apiVersion = "v1") {
        // Only accept a string of 32 characters containing only lowercase and uppercase letters and numbers
        if (!preg_match("/^([a-zA-Z0-9]{32})/", $apiKey)) {
            throw new Billy_Exception("Billy has encountered an invalid API key");
        }

        $this->apiKey = $apiKey;
        $this->apiVersion = $apiVersion;
    }

    /**
     * Run a GET request on Billy API on a specific address and receive an array as return.
     *
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     *
     * @return array Response from Billy API, e.g. invoice object
     */
    public function get($address) {
        return $this->call("GET", $address);
    }

    /**
     * Run a POST request on Billy API on a specific address with parameters and receive an array as return.
     *
     * @param string $address Sub-address to call, e.g. invoices or contacts
     * @param array $params Parameters to be sent to Billy API on the specified address
     *
     * @return array Response from Billy API, e.g. id and success
     */
    public function post($address, $params) {
        return $this->call("POST", $address, $params);
    }

    /**
     * Run a custom request on Billy API on a specific address with possible parameters and receive a response array as
     * return.
     *
     * @param string $method Either GET or POST
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     * @param OPTIONAL array $params Parameters to be sent to Billy API on the specified address
     *
     * @return array Response from Billy API, e.g. id and success or invoice object
     */
    private function call($method, $address, $params = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Authentication
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        // Request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // POST parameters
        if ($method == "POST" && $params != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        // URL including API version and sub-address
        curl_setopt($ch, CURLOPT_URL, "https://api.billysbilling.dk/" . $this->apiVersion . "/" . $address);
        $response = curl_exec($ch);
        curl_close($ch);

        // Return response array
        return json_decode($response);
    }

}