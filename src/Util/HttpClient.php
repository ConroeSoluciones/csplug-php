<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Model\HttpRequest;
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
        $this->logger->info(sprintf('Sending %s request to %s', $request->method, $request->url));

        $response = $this->client->request(
            $request->method,
            $request->url,
            $request->options
        );

        return new HttpResponse(
            $response->getStatusCode(),
            $response->getContent(false),
            $response->getHeaders(false)
        );
    }
}
