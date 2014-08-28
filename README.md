#Billy's Billing PHP SDK

PHP SDK for [Billy's Billing API](http://dev.billysbilling.dk/) version 1 and 2 from the Danish accounting program [Billy's Billing](http://www.billysbilling.com/).

For version 1:
Read [API Terms](https://dev.billysbilling.dk/api-terms) before use. For further information, see [API Docs](https://dev.billysbilling.dk/api).

For version 2:
Read [Terms](https://billysbilling.com/terms) before use. For further information, see [API Docs](https://billysbilling.com/api).

##Installation
Download code and include bootstrap.php; example using require():
```
require("path/to/billysbilling-php/bootstrap.php");
```
It might be preferable to use a relative path from the current file to include the SDK, especially when using the SDK in a module or extension:
```
require(dirname(__FILE__) . "/path/to/billysbilling-php/bootstrap.php");
```

##Examples

###Version 1
Include the bootstrap file, instantiate the Client class, retrieve all invoices and print out a list of invoice IDs.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed", "v1");

$invoices = $client->get("invoices");
foreach ($invoices as $invoice) {
  echo $invoice->id . "\n";
}
```

Include the bootstrap file, instantiate the Client class, retrive an invoice and print out some details.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed", "v1");

$invoice = $client->get("invoices/55023-NBgG9CFInhPGMP");
echo $invoice->amount . "\n";
echo $invoice->vat;
```

Include the bootstrap file, instantiate the Client class, create a new contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed", "v1");

$response = $client->post("contacts", array(
  "name" => "Billy",
  "countryId" => "DK",
  "phone" => "12345678"
));

echo $response->id;
```

Include the bootstrap file, instantiate the Client class, update a contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed", "v1");

$response = $client->put("contacts/55023-NBgG9CFInhPGMP", array(
  "name" => "John"
));
echo $response->id;
```

Include the bootstrap file, instantiate the Client class, delete a contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("054280dbff08bf095fd08683dce80aed", "v1");

$response = $client->delete("contacts/55023-NBgG9CFInhPGMP");
echo $response->id;
```

###Version 2
Include the bootstrap file, instantiate the Client class, retrieve all invoices and print out a list of invoice IDs.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("7f6439baeeebe139b5791143d8a0f568249e303a");

$response = $client->get("invoices");
foreach ($response->invoices as $invoice) {
  echo $invoice->id . "\n";
}
```

Include the bootstrap file, instantiate the Client class, retrive an invoice and print out some details.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("7f6439baeeebe139b5791143d8a0f568249e303a");

$response = $client->get("invoices/4rpFyEKzYP7HkASQRBG1ID");
$invoice = $response->invoice;
echo $invoice->amount . "\n";
echo $invoice->vat;
```

Include the bootstrap file, instantiate the Client class, create a new contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("7f6439baeeebe139b5791143d8a0f568249e303a");

$response = $client->post("contacts", array(
  "name" => "Billy",
  "countryId" => "DK",
  "phone" => "12345678"
));

echo $response->contacts[0]->id;
```

Include the bootstrap file, instantiate the Client class, update a contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("7f6439baeeebe139b5791143d8a0f568249e303a");

$response = $client->put("contacts/4rpFyEKzYP7HkASQRBG1ID", array(
  "name" => "John"
));
echo $response->contacts[0]->id;
```

Include the bootstrap file, instantiate the Client class, delete a contact and print contact ID.
```
<?php
require("billysbilling-php/bootstrap.php");

$client = new Billy_Client("7f6439baeeebe139b5791143d8a0f568249e303a");

$response = $client->delete("contacts/4rpFyEKzYP7HkASQRBG1ID");
echo $response->meta->deletedRecords->contacts[0]->id;
```
