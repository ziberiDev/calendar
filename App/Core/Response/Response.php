<?php

namespace App\Core\Response;

use http\Exception;

class Response
{
    protected array $headers = [];

    protected string $content;

    protected int|string $response_code;


    public function create(string $content, ?int $code, ?array $headers)
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
        if (isset($this->content)) {
            $this->sendHeaders();
            $this->sendResponseCode();
            return $this->content;
        }

        throw new \Exception('No content is set for the response');

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
            header(sprintf('%s : %s', $name, $value));
        }
    }

    public function sendResponseCode()
    {
        http_response_code($this->response_code);
    }
}