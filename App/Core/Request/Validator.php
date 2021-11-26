<?php

namespace App\Core\Request;

class Validator
{
    /**
     * @var array $rules
     */
    protected array $rules = [];

    /**
     * @var array $inputs
     */
    protected array $inputs = parent::GET_PARAMS ?? parent::POST_PARAMS;

    /**
     * @var array $messages
     */
    protected array $messages = [];

    /**
     * @param array $inputs
     * @param array $rules
     */
    public function validate(array $rules)
    {
        $this->setRules($this->inputs, $rules);

        foreach ($this->inputs as $input => $inputValue) {
            foreach ($this->rules[$input] as $method => $checkValue) {
                $this->$method(
                    inputValue: $inputValue,
                    input: $input,
                    checkValue: $checkValue
                );
            }
        }
    }

    /**
     * @param array $inputs
     * @param array $rules
     */
    protected function setRules(array $inputs, array $rules)
    {
        foreach ($inputs as $input => $inputValue) {
            if (array_key_exists($input, $rules)) {
                $this->rules[$input] = $this->formRules($rules[$input]);
            }
        }
    }

    /**
     * @param string $rules
     * @return array
     */
    protected function formRules(string $rules): array
    {
        $rulesArr = explode("|", $rules);
        $rulesWithValues = [];
        foreach ($rulesArr as $rule) {
            $arr = explode(":", $rule);

            $rulesWithValues[$arr[0]] = $arr[1] ?? '';
        }
        return $rulesWithValues;
    }

    /**
     * @param string|int $inputValue
     * @param string|int $checkValue
     * @param string $input
     */
    protected function required(string|int $inputValue, string $input, string|int $checkValue = 0)
    {
        if (!$inputValue) {
            $this->messages[$input][] = "The {$input} is required";
        }

    }

    /**
     * @param string|int $inputValue
     * @param string|int $checkValue
     * @param string $input
     */
    protected function min(string|int $inputValue, string $input, string|int $checkValue = 0)
    {
        if (!(strlen($inputValue) > (int)$checkValue)) {
            $this->messages[$input][] = "The {$input} must be greater than $checkValue";
        }

    }

    /**
     * @param string|int $inputValue
     * @param string|int $checkValue
     * @param string $input
     */
    protected function max(string|int $inputValue, string $input, string|int $checkValue = 0)
    {
        if (!(strlen($inputValue) < (int)$checkValue)) {
            $this->messages[$input][] = "The {$input} cant be greater than $checkValue";
        }
    }


    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (empty($this->messages)) {
            return false;
        }

        return true;
    }

    /**
     * @return array|bool
     */
    public function getMessages(): array|bool
    {
        if (!empty($this->messages)) {
            return $this->messages;
        }
        return false; // exception
    }
}

