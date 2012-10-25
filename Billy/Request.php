<?php
class Billy_Request {

    private $apiKey;
    private $apiVersion;

    /**
     * Construct a Billy Request with an API key and an API version.
     *
     * @param string $apiKey API key from Billy
     * @param string $apiVersion API version from Billy
     */
    public function __construct($apiKey, $apiVersion) {
        $this->apiKey = $apiKey;
        $this->apiVersion = $apiVersion;
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
    public function call($method, $address, $params = null) {
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
        $rawResponse = curl_exec($ch);
        curl_close($ch);

        // Return response array
        return $this->interpretResponse($rawResponse);
    }

    /**
     * Takes a raw JSON response and decodes it. If an error is met, throw an exception. Else return array.
     *
     * @param string $rawResponse JSON encoded array
     *
     * @return array Response from Billy API, e.g. id and success or invoice object
     * @throws Billy_Exception Error, Help URL and response
     */
    private function interpretResponse($rawResponse) {
        $response = json_decode($rawResponse);
        if (!$response->success) {
            throw new Billy_Exception($response->error, $response->helpUrl, $rawResponse);
        }

        return $response;
    }

}