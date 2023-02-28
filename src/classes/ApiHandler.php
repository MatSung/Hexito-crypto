<?php

class ApiHandler{
    private array $urlFormats = [
        'convert' => 'https://api.exchangerate.host/convert?from=%s&to=$s&amount=%f',
        'getCurrencies' => 'https://api.exchangerate.host/symbols'
    ];
    private string $url;

    static public function request(array $data)
    {
        switch ($data['type']) {
            case 'convert':
                return self::convert($data['inputCurrency'], $data['outputCurrency'], $data['inputAmount']);
                break;
            case 'getCurrencies':
                return self::getSymbols($data['query']);
                break;
            default:
                return null;
                break;
        }
    }

    static private function convert(string $from, string $to, float $amount): ?array
    {
        $url = sprintf('https://api.exchangerate.host/convert?from=%s&to=%s&amount=%f', $from, $to, $amount);
        $results = self::curlApiData($url);
        if($results === null){
            return null;
        }
        if($results['success'] === false){
            return null;
        }
        return ['outputAmount' => $results['result']];
    }

    static private function curlApiData(string $url): ?array
    {
        try {
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, $url);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $apiData = json_decode(curl_exec($cURLConnection), true);
            curl_close($cURLConnection);
            return $apiData;
        } catch (Exception $e) {
            return null;
        }
    }

    static private function getSymbols($query): ?array
    {
        $url ='https://api.exchangerate.host/symbols';
        $apiResults = self::curlApiData($url);
        if($apiResults === null){
            return null;
        }
        if($apiResults['success'] === false){
            return null;
        }

        $results = [];
        $results['currencies'] = array_filter($apiResults['symbols'], fn($item) => str_starts_with($item['code'],$query));
        $results['currencies'] = array_slice($results['currencies'], 0, 3);
        // filter here
        return ['currencies'=> $results['currencies']];
    }
}