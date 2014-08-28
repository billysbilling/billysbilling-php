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
     * @param string $method Either GET, POST, PUT or DELETE
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     * @param null $params Parameters to be sent to Billy API on the specified address
     *
     * @return StdClass Response from Billy API, e.g. id and success or invoice object
     */
    public function call($method, $address, $params = null) {
        $headers = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Authentication
        if ($this->apiVersion === "v1") {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        } else {
            $headers[] = "X-Access-Token: " . $this->apiKey;
        }
        // Request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // POST parameters
        if (($method == "POST" || $method == "PUT") && $params != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            $headers[] = "Content-Type: application/json";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // URL including API version and sub-address
        curl_setopt($ch, CURLOPT_URL, "https://api.billysbilling." . ($this->apiVersion === "v1" ? "dk" : "com") . "/" . $this->apiVersion . "/" . $address);
        $rawResponse = curl_exec($ch);
        curl_close($ch);

        // Return response array
        return $this->interpretResponse($rawResponse);
    }

    /**
     * Run a fake custom request.
     *
     * @param string $outputFile The file used to print responses
     * @param string $method Either GET, POST, PUT or DELETE
     * @param string $address Sub-address to call, e.g. invoices or invoices/ID_NUMBER
     * @param null $params Parameters to be sent to Billy API on the specified address
     *
     * @return StdClass Response from Billy API, e.g. id and success or invoice object
     */
    public function fakeCall($outputFile, $method, $address, $params = null) {
        $call = array(
            "mode" => $method,
            "address" => $address
        );
        if ($params) {
            $call["params"] = $params;
        }

        $handle = fopen($outputFile, "a");
        fwrite($handle, json_encode($call) . "\n");
        fclose($handle);

        $response = new StdClass();
        if ($method == "POST") {
            $response->id = "12345-ABCDEFGHIJKLMNOP";
            $response->success = true;
        } else {
            $addressParts = explode("?", $address);
            $type = $addressParts[0];
            $response->$type = array();
        }
        return $response;
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
        $success = $this->apiVersion === "v1" ? $response->success : $response->meta->success;
        if (!$success) {
            throw new Billy_Exception($response->error, $response->helpUrl, $rawResponse);
        }

        return $response;
    }

}