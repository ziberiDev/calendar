<?php

namespace App\Core\Request;

use App\Core\Database\QueryBuilder;

class Validator
{


    /**
     * @var array $rules
     */
    protected array $rules = [];


    protected array|\stdClass $inputs;

    /**
     * @var array $messages
     */
    protected array $messages = [];

    public function __construct(protected QueryBuilder $db)
    {
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function validate(array $rules): static
    {
        //TODO:ask about polymorphic call
        $this->inputs = $this->getParams();

        $this->setRules($this->inputs, $rules);

        foreach ($this->inputs as $input => $inputValue) {
            if (!key_exists($input, $this->rules)) break;
            foreach ($this->rules[$input] as $method => $checkValue) {
                $this->$method(
                    inputValue: $inputValue,
                    input: $input,
                    checkValue: $checkValue
                );
            }
        }
        return $this;
    }

    /**
     * @param $inputs
     * @param array $rules
     */
    protected function setRules($inputs, array $rules)
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
     * Check if the input value is present.
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
     * @param string $input
     * @param string|int $checkValue
     */
    protected function optional(string|int $inputValue, string $input, string|int $checkValue = 0)
    {
        //
    }

    /**
     * Check the input value for min length <value> characters.
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
     * Check the input value for max length <value> characters.
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
     * Check the input value if it is in a valid mail format.
     * @param string|int $inputValue
     * @param string $input
     * @param string|int $checkValue
     */
    public function email(string|int $inputValue, string $input, string|int $checkValue = 0)
    {
        if (!filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
            $this->messages[$input][] = "The {$input} must be a valid email";
        }
    }

    /**
     * Match the value from input with custom regex expression
     * @param string $inputValue
     * @param string $input
     * @param string|int $checkValue
     */
    public function regex(string $inputValue, string $input, string|int $checkValue = 0)
    {
        if (!preg_match("$checkValue", $inputValue)) {
            $this->messages[$input][] = "The {$input} doesn't meet the requirements.";
        }
    }

    /**
     * @param string $inputValue
     * @param string $input
     * @param string|int $checkValue
     */
    public function exists(string $inputValue, string $input, string|int $checkValue = 0)
    {
        $emails = $this->db->select($input)->from($checkValue)->where($input, '=', $inputValue)->get();
        if ($emails) {
            $this->messages[$input][] = "The {$input} already exists.";
        }
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (!empty($this->messages)) {
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

