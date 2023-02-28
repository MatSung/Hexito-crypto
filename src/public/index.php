<?php
// Main page
// 4 input fields
//  Amount input
//  currency selector - simple three currency dropdown
//  crypto input - manual input with API help (eg. ETH, BTC, ADA, etc.)
//  provider - Main Provider: https://exchangerate.host/#/docs
//  submit button
// soft lock on provider when PLN is selected

// bootstrap installation

// create a class for database connection and storing history in the database

// write the javascript to send a request to the api,
//  fancy loading preview
// write the api to accept a request with POST details and return a json
//  dont forget data validation
//  api validation

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Crypto for you</title>
</head>

<body class="bg-light">
    <div class="container">
        <main>
            <header class="pb-3 my-4 border-bottom text-center">
                <h1>Crypto converter</h1>
            </header>
            <div id="form" class="row w-100 g-3 bg-white p-3 my-4 rounded-3 mx-auto">
                <div class="col-md-4">
                    <label for="amount-input" class="form-label">Amount</label>
                    <input id="inputAmount" name='amount-input' type="text" placeholder='0.00' maxlength="12" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="from-currency" class="form-label">From</label>
                    <select class="form-select" name="from-currency" id="inputCurrency">
                        <option value="EUR" selected>EUR</option>
                        <option value="USD">USD</option>
                        <option value="PLN">PLN</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="crypto-currency" class="form-label">To</label>
                    <input id="outputCurrency" style="text-transform: uppercase;" class="form-control" type="crypto-currency" placeholder="BTC...">
                    <ul class="dropdown-menu" id='currency-suggestions'>
                        <!-- <li><a class="dropdown-item" value='EUR' href="#">EUR - Euro</a></li> -->
                    </ul>
                </div>
                <div class="col-sm-4">
                    <label for="provider" class="form-label">Provider</label>
                    <select class="form-select" name="provider" id="provider">
                        <option value="exchangerate" selected>exchangerate.host</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-12 border-top">
                    <button id="convert-button" class="w-100 btn btn-primary btn-lg mt-2" type="button">
                        <span class="loader spinner-border visually-hidden" role="status" aria-hidden="true"></span>
                        <span class="inner-span">Convert</span></button>
                </div>
            </div>
            <div id="result-element" class="bg-white p-3 my-4 rounded-3 text-center">
                <div class="spinner-grow loader visually-hidden" style="width: 4rem; height: 4rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h1 id="result" class="inner-span">0.00 ABC ≈ 0.00 ABC</h2>
            </div>

        </main>
    </div>
    <script type="module" src="/api-handler.js"></script>
</body>

</html>