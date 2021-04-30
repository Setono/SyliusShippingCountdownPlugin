<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSyliusShippingCountdownExtension extends AbstractResourceExtension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /** @psalm-suppress PossiblyNullArgument */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        /** @psalm-suppress MixedArgument */
        $this->registerResources('setono_sylius_shipping_countdown', $config['driver'], $config['resources'], $container);

        $loader->load('services.xml');
    }
}
