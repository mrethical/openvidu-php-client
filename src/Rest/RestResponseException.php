<?php

declare(strict_types=1);

namespace Stopka\OpenviduPhpClient\Rest;

use GuzzleHttp\Exception\RequestException;

class RestResponseException extends RestClientException
{
    protected const KEY_MESSAGE = 'message';

    /** @var RestResponse|null */
    private ?RestResponse $response;

    public function __construct(RequestException $previous)
    {
        $httpResponse = $previous->getResponse();
        $message = null;
        if (null !== $httpResponse) {
            $this->response = new RestResponse($httpResponse);
            try {
                $message = $this->response->getStringInArrayKey(self::KEY_MESSAGE);
            } catch (RestResponseInvalidException $e) {
            }
        }
        $message = $message ?? $previous->getMessage();
        parent::__construct($message, $previous->getCode(), $previous);
    }
}
