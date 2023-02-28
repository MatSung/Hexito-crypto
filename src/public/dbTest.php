<?php

require_once '../classes/DbHandler.php';

$db = new DbHandler();

// $db->selectAll();

$data = [
    'inputCurrency' => 'EUR',
    'inputAmount' => 12,
    'outputCurrency' => 'USD',
    'outputAmount' => 12.2,
    'provider' => 'exchangerate.host'
];

$db->insertHistory($data);