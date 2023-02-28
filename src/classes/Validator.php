<?php

class Validator
{

    private array $expectedInputs = [
        'convert' => [
            'inputAmount',
            'inputCurrency',
            'outputCurrency',
            'provider'
        ],
        'getCurrencies' => [
            'query'
        ]
    ];

    private array $validatedData = [];

    function __construct(private string $method, private string $type)
    {
        
    }

    public function validate(): bool
    {

        if(!in_array($this->type,array_keys($this->expectedInputs))){
            return false;
        }
        $this->validatedData['type'] = $this->type;
        try {
            if ($this->method == 'POST') {
                foreach ($this->expectedInputs[$this->type] as $key) {
                    if (!isset($_POST[$key])) {
                        return false;
                    }
                    $this->validatedData[$key] = $_POST[$key];
                }
            }
            if ($this->type == 'convert' && !is_numeric($this->validatedData['inputAmount'])) {
                // check if it's positive
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function populate(): array
    {
        return $this->validatedData;
    }
}
