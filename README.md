#Billy's Billing PHP SDK

PHP SDK for [Billy's Billing API](http://dev.billysbilling.dk/) from the Danish accounting program [Billy's Billing](http://www.billysbilling.dk/).

Read [API Terms](https://dev.billysbilling.dk/api-terms) before use. For further information, see [API Docs](https://dev.billysbilling.dk/api).

##Installation
Download code and include bootstrap.php; example using require():
```
require("path/to/billysbilling-php/bootstrap.php");
```

##Examples
Include the bootstrap file, instantiate the Client class, retrieve all invoices and print out a list of invoice IDs.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed");

$invoices = $client->get("invoices");
foreach ($invoices as $invoice) {
  echo $invoice->id . "\n";
}
```

Include the bootstrap file, instantiate the Client class, retrive an invoice and print out some details.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed");

$invoice = $client->post("invoices/55023-NBgG9CFInhPGMP");
echo $invoice->amount . "\n";
echo $invoice->vat;
```

Include the bootstrap file, instantiate the Client class, create a new contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed");

$response = $client->post("contacts", array(
  "name" => "Billy",
  "countryId" => "DK",
  "phone" => "12345678"
));

echo $response->id;
```

_By the way don't bother trying the API key, it is simply the MD5 hash of "Billy is awesome"._ ;-)