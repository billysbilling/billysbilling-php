<?php
class Billy_Exception extends Exception {
    public function __construct($message = null, $help_url = null, $json_body = null) {
        parent::__construct($message);
        $this->help_url = $help_url;
        $this->json_body = $json_body;
    }

    public function getHelpUrl() {
        return $this->help_url;
    }

    public function getJsonBody() {
        return $this->json_body;
    }
}