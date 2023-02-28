<?php

class DbHandler
{

    private string $servername = 'database';
    private string $port = '3306';
    private string $username = 'crypto';
    private string $password = 'cryptopassword';
    private string $databaseName = 'cryptodb';
    private PDO $conn;

    function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->databaseName", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully" . PHP_EOL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function selectAll(){
        $sql = "SELECT * from History";
        $result = $this->conn->query($sql);
        print_r($result->fetchAll());
    }

    public function insertHistory(array $data){
        // template is 
        // [
        //   'inputCurrency' => string,
        //   'inputAmount' => float,
        //   'outputCurrency' => string,
        //   'outputAmount' => float,
        //   'provider' => string
        // ]
        $inputCurrency = $data['inputCurrency'];
        $inputAmount = $data['inputAmount'];
        $outputCurrency = $data['outputCurrency'];
        $outputAmount = $data['outputAmount'];
        $provider = $data['provider'];

        $sql = "INSERT INTO History (inputCurrency, inputAmount, outputCurrency, outputAmount, provider)
                VALUES ('$inputCurrency', '$inputAmount', '$outputCurrency', '$outputAmount', '$provider')";
        $result = $this->conn->query($sql);
        // print_r($result->fetchAll());
    }
}
