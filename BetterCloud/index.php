<?php

require_once 'include/DbHandler.php';
require_once 'include/PassHash.php';
require 'vendor/autoload.php';
\Slim\Slim::registerAutoloader();

//$env = \Slim\Environment::getInstance();
//$env['slim.errors'] = fopen( 'C:\error\log.txt', 'a' );


$app = new \Slim\Slim(array(
    'debug' => true
));


$app->get('/companydetails', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->selectCompanyData();
    echoRespnse(200, $response);
});

$app->get('/getallemployees', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getAllEmployees();
    echoRespnse(200, $response);
});

$app->get('/getemployeesofbettercloud', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEmployeesByCompany("70d6cfca-b64d-4c1f-b50a-7299d820daf8");
    echoRespnse(200, $response);
});

$app->get('/getemployeesoflinkedin', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEmployeesByCompany("642047bc-2a9b-46f7-8e55-98ed612216e7");
    echoRespnse(200, $response);
});

$app->get('/getemployeesofgoogle', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEmployeesByCompany("95d1f2f3-977b-4949-a75e-c10f7f73408f");
    echoRespnse(200, $response);
});

$app->get('/getemployeesofapple', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEmployeesByCompany("61064995-6e15-4f18-b0b3-4547b4829d0a");
    echoRespnse(200, $response);
});

$app->get('/geteventlocationofgoogle', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEventLocationByCompanyID("95d1f2f3-977b-4949-a75e-c10f7f73408f");

    echoRespnse(200, $response);
});

$app->get('/geteventlocationofbettercloud', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEventLocationByCompanyID("70d6cfca-b64d-4c1f-b50a-7299d820daf8");

    echoRespnse(200, $response);
});


$app->get('/geteventlocationofapple', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEventLocationByCompanyID("61064995-6e15-4f18-b0b3-4547b4829d0a");

    echoRespnse(200, $response);
});

$app->get('/geteventlocationoflinkedin', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEventLocationByCompanyID("642047bc-2a9b-46f7-8e55-98ed612216e7");

    echoRespnse(200, $response);
});

$app->get('/getsuspiciouseventslocation', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getSuspiciousEventLocation();

    echoRespnse(200, $response);
});

$app->get('/getsuspiciouseventslocation', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getSuspiciousEventLocation();

    echoRespnse(200, $response);
});

$app->get('/getsuspiciouseventemployee', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getSuspiciousEventEmployee();

    echoRespnse(200, $response);
});

$app->get('/getfairevents', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getEventSuspiciousInformation("false");

    echoRespnse(200, $response);
});

$app->get('/getlocationofallevents', function() use ($app) {

    $response = array();

    $db = new DbHandler();
    $response = $db->getLocationOfAllEvents();

    echoRespnse(200, $response);
});

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();

	
