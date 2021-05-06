<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\DependencyInjection;

use LogicException;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSyliusShippingCountdownExtension extends AbstractResourceExtension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-var array{cache: array{enabled: bool, pool: ?string}, driver: string, resources: array}
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        /** @psalm-suppress MixedArgument */
        $this->registerResources('setono_sylius_shipping_countdown', $config['driver'], $config['resources'], $container);

        $cacheEnabled = $config['cache']['enabled'];
        if ($cacheEnabled) {
            if (!interface_exists(AdapterInterface::class)) {
                throw new LogicException('Using cache is only supported when symfony/cache is installed.');
            }

            if (null === $config['cache']['pool']) {
                throw new LogicException('You should specify pool in order to use cache.');
            }

            $container->setAlias('setono_sylius_shipping_countdown.cache', $config['cache']['pool']);

            $loader->load('services/conditional/cache.xml');
        }

        $container->setParameter('setono_sylius_shipping_countdown.cache.enabled', $cacheEnabled);

        $loader->load('services.xml');
    }
}
