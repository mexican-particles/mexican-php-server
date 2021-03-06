<?php

declare(strict_types=1);

namespace App\Application\Presenters;

use App\Application\Actions\ActionPayload;
use Illuminate\Support\Collection;
use JsonSerializable;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BasePresenter
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Collection|JsonSerializable|null $data
     * @return Response
     */
    protected function respondWithData($data = null): Response
    {
        $payload = new ActionPayload(200, $data);
        return $this->respond($payload);
    }

    /**
     * @param ActionPayload $payload
     * @return Response
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        assert(is_string($json));
        $response = $this->responseFactory->createResponse();
        $response->getBody()->write($json);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
