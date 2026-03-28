<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Laravel;

use Csfacturacion\CsPlug\Auth\AuthStrategyFactory;
use Csfacturacion\CsPlug\Contracts\AuthStrategy;
use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\CsPlugClient;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Util\CsPlugRequestFactory;
use Csfacturacion\CsPlug\Util\HttpClientAdapter;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

use function class_exists;
use function is_array;

if (class_exists(ServiceProvider::class)) {
    final class CsPlugServiceProvider extends ServiceProvider
    {
        public function register(): void
        {
            $this->mergeConfigFrom(
                __DIR__ . '/../../config/csplug.php',
                'csplug',
            );

            // Bind HttpClient interface to implementation
            $this->app->singleton(HttpClient::class, fn () => new HttpClientAdapter());

            // Bind RequestFactory interface to implementation with config
            $this->app->singleton(RequestFactory::class, function (Container $app) {
                $config = $this->getConfig($app);
                $csPlugConfig = CsPlugConfig::fromArray($config);

                return new CsPlugRequestFactory($csPlugConfig);
            });

            // Bind AuthStrategy
            $this->app->singleton(AuthStrategy::class, function (Container $app) {
                $config = $this->getConfig($app);
                $csPlugConfig = CsPlugConfig::fromArray($config);

                return AuthStrategyFactory::create($csPlugConfig);
            });

            // Bind CsPlugClient with all dependencies
            $this->app->singleton(CsPlugClient::class, function (Container $app) {
                $config = $this->getConfig($app);

                /** @var HttpClient $httpClient */
                $httpClient = $app->make(HttpClient::class);

                /** @var RequestFactory $requestFactory */
                $requestFactory = $app->make(RequestFactory::class);

                return new CsPlugClient(
                    httpClient: $httpClient,
                    requestFactory: $requestFactory,
                    config: CsPlugConfig::fromArray($config),
                );
            });

            $this->app->alias(CsPlugClient::class, 'csplug');
        }

        public function boot(): void
        {
            if ($this->app->runningInConsole()) {
                $this->publishes([
                    __DIR__ . '/../../config/csplug.php' => $this->app->configPath('csplug.php'),
                ], 'csplug-config');
            }
        }

        /**
         * @return array<string, mixed>
         */
        private function getConfig(Container $app): array
        {
            $configRepository = $app->make('config');

            if (!$configRepository instanceof Repository) {
                throw new RuntimeException('Invalid config repository.');
            }

            $config = $configRepository->get('csplug', []);

            if (!is_array($config)) {
                $config = [];
            }

            // Set defaults
            return [
                'base_uri' => $config['base_uri'] ?? 'https://csplug.csfacturacion.com',
                'timeout' => $config['timeout'] ?? 30,
                'connect_timeout' => $config['connect_timeout'] ?? 10,
                'auth_mode' => $config['auth_mode'] ?? 'basic',
                'username' => $config['username'] ?? null,
                'password' => $config['password'] ?? null,
                'bearer_token' => $config['bearer_token'] ?? null,
                'contract_id' => $config['contract_id'] ?? null,
                'x_servicio' => $config['x_servicio'] ?? null,
                'debug' => $config['debug'] ?? false,
            ];
        }
    }
}
