<?php
if (!function_exists("curl_init")) {
    throw new Exception("Billy needs the CURL PHP extension.");
}
if (!function_exists("json_decode")) {
    throw new Exception("Billy needs the JSON PHP extension.");
}

require(dirname(__FILE__) . "/Billy/Client.php");
require(dirname(__FILE__) . "/Billy/Exception.php");
require(dirname(__FILE__) . "/Billy/Request.php");