<?php

require('../vendor/autoload.php');

use Parse\ParseClient;
use Parse\ParseObject;

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Our web handlers
$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  echo "post <br>";

  $message = $_GET['Message'];
  $petID = $_GET['PetID'];
  $feedQuantity = $_GET['FeedQuantity'];

	$person_info = array(
    "Message" => $message,
    "petID" => $petID,
    "feedQuantity" => $feedQuantity
	);

// Agora transformamos esse Array em uma String
// formatada em JSON
$data = json_encode($person_info);

	$ch = curl_init('https://api.parse.com/1/classes/Notification');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'X-Parse-Application-Id: 4pv3lCCAjRS7PXyWJgEKxTES5XWVe1RucTuEpcwJ',
			'X-Parse-REST-API-Key: J9g6F9Gx8PGvLXfVi6ORFHnCNtlVaDiqrM8NXMcM',
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($data))
	);

	$result = curl_exec($ch);
	echo "Result = ";
	echo $result;

  return 'Hello2';
});

$app->run();

// Add the "use" declarations where you'll be using the classes


?>
