<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Laravel;

use Csfacturacion\CsPlug\CsPlugClient;
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

            $this->app->singleton(CsPlugClient::class, function ($app) {
                /** @var Container $app */
                $configRepository = $app->make('config');

                if (!$configRepository instanceof Repository) {
                    throw new RuntimeException('Invalid config repository.');
                }

                $config = $configRepository->get('csplug', []);

                if (!is_array($config)) {
                    $config = [];
                }

                /** @var array<string, mixed> $config */
                return CsPlugClient::create([
                    'base_uri' => $config['base_uri'] ?? 'https://csplug.csfacturacion.com',
                    'timeout' => $config['timeout'] ?? 30,
                    'connect_timeout' => $config['connect_timeout'] ?? 10,
                    'auth_mode' => $config['auth_mode'] ?? null,
                    'username' => $config['username'] ?? null,
                    'password' => $config['password'] ?? null,
                    'bearer_token' => $config['bearer_token'] ?? null,
                    'contract_id' => $config['contract_id'] ?? null,
                    'x_servicio' => $config['x_servicio'] ?? null,
                    'debug' => $config['debug'] ?? false,
                ]);
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
    }
}
