<?php
class Billy_Client {

    private $request;

    /**
     * Construct a Billy Client with an API key and optionally an API version.
     *
     * @param string $apiKey API key from Billy
     * @param string $apiVersion Optional (currently v1)
     */
    public function __construct($apiKey, $apiVersion = "v1") {
        // Only accept a string of 32 characters containing only lowercase and uppercase letters and numbers
        if (!preg_match("/^([a-zA-Z0-9]{32})/", $apiKey)) {
            throw new Billy_Exception("Billy has encountered an invalid API key");
        }

        $this->request = new Billy_Request($apiKey, $apiVersion);
    }

    /**
     * Run a GET request on Billy API on a specific address and receive an array as return.
     *
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     *
     * @return array Response from Billy API, e.g. invoice object
     */
    public function get($address) {
        return $this->request->call("GET", $address);
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
        return $this->request->call("POST", $address, $params);
    }

}