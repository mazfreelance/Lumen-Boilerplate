<?php

use App\Ship\Support\Facades\Logger;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

abstract class HttpService
{
    protected $baseUrl;

    protected $client;

    protected $method;

    protected $headers;

    protected $options;

    protected $payload;

    protected $url;

    protected $class;

    protected $userId = null;

    protected $httpErrors = false;

    /**
     * Create a new service instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl
        ]);
    }

    /**
     * Set Base Url
     *
     * @param string $baseUrl
     * @return void
     */
    protected function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Set Class
     *
     * @param string $class
     * @return void
     */
    protected function setClass(string $class): void
    {
        $this->class = $class;
    }


    /**
     * Set User ID
     *
     * @param int $userId
     * @return void
     */
    protected function setUserId(?string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Set Method
     *
     * @param string $method
     * @return void
     */
    protected function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * Set Headers
     *
     * @param array $headers
     * @return void
     */
    protected function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Set Authentication Header
     *
     * @param string $accessToken
     * @return void
     */
    protected function setAuthenticationHeader(string $accessToken): void
    {
        $this->headers['Authorization'] = "Bearer {$accessToken}";
    }

    /**
     * Set Url
     *
     * @param string $url
     * @return void
     */
    protected function setUrl(string $url): void
    {
        $url = "{$this->baseUrl}{$url}";
        $this->url = $url;
    }

    /**
     * Set Payload
     *
     * @param array $payload
     * @return void
     */
    protected function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * Set Options
     *
     * @param string $bodyType
     * @return void
     */
    protected function setOptions(string $bodyType = "json"): void
    {
        if (!in_array($bodyType, ["json", "form_params", "query"])) {
            throw new BadRequestException(__("message.guzzle.invalid_body_type"));
        }

        $options = [
            "http_errors" => $this->httpErrors,
            "headers" => $this->headers,
            $bodyType => $this->payload,
        ];

        $this->options = $options;
    }

    /**
     * Execute
     *
     * @return array|void
     * @throws \Symfony\Component\HttpFoundation\Exception\BadRequestException
     */
    protected function execute()
    {
        try {
            $result = $this->client->request($this->method, $this->url, $this->options);
            $response = [
                "status_code" => $result->getStatusCode(),
                "body" => json_decode($result->getBody(), true)
            ];

            Logger::serviceLog($this->userId, $this->class, $this->url, $this->headers, $this->payload, $response['status_code'], $response['body']);

            return $response;
        } catch (\Exception $ex) {
            Logger::serviceLog($this->userId, $this->class, $this->url, $this->headers, $this->payload, 500, ["message" => $ex->getMessage()]);

            throw new BadRequestException($ex->getMessage() ?? __('message.guzzle.request_error'));
        }
    }

    /**
     * Throw Exception
     *
     * @param string $message
     * @param int $code
     *
     * @return void
     * @throws \Symfony\Component\HttpFoundation\Exception\BadRequestException
     */
    protected function throwException(string $message, int $code = 0)
    {
        throw new BadRequestException($message, $code);
    }
}
