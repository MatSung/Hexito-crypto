<?php

function serveData($datas, $query, $code = 400, $status = 'error')
{
    $result = [
        'status' => $status,
        'query' => $query,
        $status == 'error' ? 'message' : 'result' => $datas
    ];
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($result);
    // replace die with something else
    fastcgi_finish_request();
    die();
}

require_once '../classes/ApiHandler.php';
require_once '../classes/DbHandler.php';
require_once '../classes/Validator.php';

$type = $_POST['type'] ?? null;

if ($type === null) {
    serveData('No type provided.', $type);
}

$validator = new Validator('POST', $type);
if (!$validator->validate()) {
    serveData('Invalid data provided.', $type);
}

$data = [];
$data['query'] = $validator->populate();

try {
    $result = ApiHandler::request($data['query']);
    if (!$result) {
        serveData('No data received from backend.', $data['query']);
    }
} catch (\Throwable $th) {
    serveData('Backend Api Error: ' . $th->getMessage(), $data['query']);
}

$data['result'] = $result;

if ($data['query']['type'] == 'convert') {
    $dbHandler = new DbHandler();
    $dbData = [
        'inputCurrency' => $data['query']['inputCurrency'],
        'inputAmount' => $data['query']['inputAmount'],
        'outputCurrency' => $data['query']['outputCurrency'],
        'outputAmount' => $data['result']['outputAmount'],
        'provider' => 'exchangerate.host'
    ];
    $dbHandler->insertHistory($dbData);
}

// format response
serveData($data['result'], $data['query'], 200, 'success');






// handle api sending and receiving
// curl

// echo json_encode(
//     [
//         'status' => 'success',
//         'result' => 
//         [
//         'inputAmount' => 2.00,
//         'inputCurrency' => 'EUR',
//         'outputAmount' => 0.00001,
//         'outputCurrency' => 'BTC'
//         ]
//     ]
// );

// receive a post in formdata, return whatever, store successful request in database

// get and check post data

// contact api

// troubleshoot api details

// store data in database

// return data or error