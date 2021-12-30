<?php

namespace App\Core\Response;

use App\Core\Exceptions\ResponseErrorException;
use http\Exception;

class Response
{
    protected array $headers = [

    ];

    protected string|array $content;

    protected int|string $response_code;

    private $errorResponseCodes = [
        401
    ];

    public function create(string $content = '', ?int $code = 200, ?array $headers = [])
    {
        if ($code) {
            $this->setResponseCode($code);
        }
        if ($headers) {
            $this->setHeaders($headers);
        }
        $this->content = $content;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendResponseCode();
        if ($this->checkErrorResponseCode()) {
            throw new ResponseErrorException($this->content);
        }
        return $this->content;
    }

    protected function setResponseCode(int $code)
    {
        $this->response_code = $code;
    }

    protected function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->headers[$name] = $value;
        }
    }

    protected function sendHeaders()
    {
        foreach ($this->headers as $name => $value) {
            header(sprintf('%s : %s', $name, $value), true);
        }
    }

    protected function sendResponseCode()
    {
        http_response_code($this->response_code);
    }

    protected function checkErrorResponseCode()
    {
        if (in_array($this->response_code, $this->errorResponseCodes)) {
            return true;
        }
        return false;
    }
}