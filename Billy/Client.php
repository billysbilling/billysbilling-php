<?php
class Billy_Client {

    private $request;

    /**
     * Construct a Billy Client with an API key and optionally an API version.
     *
     * @param string $apiKey API key from Billy
     * @param string $apiVersion Optional (default is v2)
     *
     * @throws Billy_Exception
     */
    public function __construct($apiKey, $apiVersion = "v2") {
        // Only accept a string characters (32 for v1, 40 for v2) containing only lowercase and uppercase letters and numbers
        if (($apiVersion === "v1" && !preg_match("/^([a-zA-Z0-9]{32})/", $apiKey)) || ($apiVersion === "v2" && !preg_match("/^([a-zA-Z0-9]{40})/", $apiKey))) {
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

    /**
     * Run a PUT request on Billy API on a specific address with parameters and receive an array as return.
     *
     * @param string $address Sub-address to call, e.g. invoices or contacts
     * @param array $params Parameters to be sent to Billy API on the specified address
     *
     * @return array Response from Billy API, e.g. id and success
     */
    public function put($address, $params) {
        return $this->request->call("PUT", $address, $params);
    }

    /**
     * Run a DELETE request on Billy API on a specific address with parameters and receive an array as return.
     *
     * @param string $address Sub-address to call, e.g. invoices or contacts
     *
     * @return array Response from Billy API, e.g. id and success
     */
    public function delete($address) {
        return $this->request->call("DELETE", $address);
    }

    /**
     * Run a fake GET request.
     *
     * @param string $outputFile The file used to print responses
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     *
     * @return array Response from Billy API, e.g. invoice object
     */
    public function fakeGet($outputFile, $address) {
        return $this->request->fakeCall($outputFile, "GET", $address);
    }

    /**
     * Run a fake POST request.
     *
     * @param string $outputFile The file used to print responses
     * @param string $address Sub-address to call, e.g. invoices or contacts
     * @param array $params Parameters to be sent to Billy API on the specified address
     *
     * @return array Response from Billy API, e.g. id and success
     */
    public function fakePost($outputFile, $address, $params) {
        return $this->request->fakeCall($outputFile, "POST", $address, $params);
    }

    /**
     * Run a fake PUT request.
     *
     * @param string $outputFile The file used to print responses
     * @param string $address Sub-address to call, e.g. invoices or contacts
     * @param array $params Parameters to be sent to Billy API on the specified address
     *
     * @return array Response from Billy API, e.g. id and success
     */
    public function fakePut($outputFile, $address, $params) {
        return $this->request->fakeCall($outputFile, "PUT", $address, $params);
    }

    /**
     * Run a fake DELETE request.
     *
     * @param string $outputFile The file used to print responses
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     *
     * @return array Response from Billy API, e.g. invoice object
     */
    public function fakeDelete($outputFile, $address) {
        return $this->request->fakeCall($outputFile, "DELETE", $address);
    }

}