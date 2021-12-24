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

    public function __construct(protected QueryBuilder $db){}

    /**
     * @param array $rules
     * @return $this
     */
    public function validate(array $rules): static
    {
        //TODO:ask about polymorphic call
        $this->inputs = $this->getParams();

        // If inputs from request are empty set keys from rules
        if (!$this->inputs) {
            foreach ($rules as $key => $value) {
                $this->inputs[$key] = "";
            }
        }
        $this->setRules($this->inputs, $rules);
        foreach ($this->inputs as $input => $inputValue) {
            if (!key_exists($input, $this->rules)) break;
            foreach ($this->rules[$input] as $method => $checkValue) {
                $continue = $this->$method(
                    inputValue: $inputValue,
                    input: $input,
                    checkValue: $checkValue
                );
                if (!$continue) {
                    break;
                }
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
     * @return bool
     */
    protected function required(string|int $inputValue, string $input, string|int $checkValue = 0): bool
    {
        if (!$inputValue) {
            $this->messages[$input][] = "The {$input} is required";
            return false;
        }
        return true;
    }

    /**
     * @param string|int $inputValue
     * @param string $input
     * @param string|int $checkValue
     * @return bool
     */
    protected function optional(string|int $inputValue, string $input, string|int $checkValue = 0): bool
    {
        return true;
    }

    /**
     * Check the input value for min length <value> characters.
     * @param string|int $inputValue
     * @param string|int $checkValue
     * @param string $input
     * @return bool
     */
    protected function min(string|int $inputValue, string $input, string|int $checkValue = 0): bool
    {
        if (!(strlen($inputValue) > (int)$checkValue)) {
            $this->messages[$input][] = "The {$input} must be greater than $checkValue";
        }
        return true;
    }

    /**
     * Check the input value for max length <value> characters.
     * @param string|int $inputValue
     * @param string|int $checkValue
     * @param string $input
     * @return bool
     */
    protected function max(string|int $inputValue, string $input, string|int $checkValue = 0): bool
    {
        if (!(strlen($inputValue) < (int)$checkValue)) {
            $this->messages[$input][] = "The {$input} cant be greater than $checkValue";
        }
        return true;
    }

    /**
     * Check the input value if it is in a valid mail format.
     * @param string|int $inputValue
     * @param string $input
     * @param string|int $checkValue
     */
    public function email(string|int $inputValue, string $input, string|int $checkValue = 0): bool
    {
        if (!filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
            $this->messages[$input][] = "The {$input} must be a valid email";
        }
        return true;
    }

    /**
     * Match the value from input with custom regex expression
     * @param string $inputValue
     * @param string $input
     * @param string|int $checkValue
     * @return bool
     */
    public function regex(string $inputValue, string $input, string|int $checkValue = 0): bool
    {
        if (!preg_match("$checkValue", $inputValue)) {
            $this->messages[$input][] = "The {$input} doesn't meet the requirements.";
        }
        return true;
    }

    /**
     * The rule states that the value must exist in database.
     * @param string $inputValue
     * @param string $input
     * @param string|int $checkValue
     * @return bool
     */
    public function exists(string $inputValue, string $input, string|int $checkValue = 0): bool
    {
        $emails = $this->db->select($input)->from($checkValue)->where($input, '=', $inputValue)->get();
        var_dump('Hello');
        if (!$emails) {
            $this->messages[$input][] = "The {$input} must exist.";
        }
        return true;
    }

    /**
     * The rule states that the value can't exist i database.
     * @param string $inputValue
     * @param string $input
     * @param string|int $checkValue
     * @return bool
     */
    public function not_in(string $inputValue, string $input, string|int $checkValue = 0): bool
    {
        $emails = $this->db->select($input)->from($checkValue)->where($input, '=', $inputValue)->get();
        if ($emails) {
            $this->messages[$input][] = "The {$input} already exists.";
        }
        return true;
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

