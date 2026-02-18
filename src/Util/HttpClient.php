<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\Builder;
use Csfacturacion\CsPlug\Model\HttpResponse;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient as SymfonyHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class HttpClient
{
    private HttpClientInterface $client;
    private LoggerInterface $logger;

    public function __construct(
        ?HttpClientInterface $client = null,
        ?LoggerInterface $logger = null
    ) {
        $this->client = $client ?? SymfonyHttpClient::create();
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Throwable
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function send(HttpRequest $request): HttpResponse
    {
        $this->logger->info(sprintf('Sending %s request to %s', $request->getHttpMethod()->name, $request->getUrl()));

        $options = [
            "headers" => $request->getHeaders(),
        ];

        if($request->getParams()->getEntity() instanceof Builder) {
            $options['json'] = $request->getParams()->getEntity()->build();
        } elseif($request->getParams()->getEntity()) {
            $options['json'] = $request->getParams()->getEntity();
        }


        $response = $this->client->request(
            $request->getHttpMethod()->name,
            $request->getUrl(),
            $options
        );

        return new HttpResponse(
            $response->getContent(false),
            $response->getStatusCode(),
            $response->getHeaders(false)
        );
    }
}
