<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\DependencyInjection;

use Setono\SyliusShippingCountdownPlugin\Form\Type\ShippingScheduleType;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingSchedule;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingScheduleInterface;
use Setono\SyliusShippingCountdownPlugin\Repository\ShippingScheduleRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_sylius_shipping_countdown');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $node = $rootNode->addDefaultsIfNotSet()->children();
        $node->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM);

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        /**
         * @psalm-suppress MixedMethodCall
         * @psalm-suppress PossiblyUndefinedMethod
         * @psalm-suppress PossiblyNullReference
         */
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('shipping_schedule')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(ShippingSchedule::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(ShippingScheduleInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(ShippingScheduleRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(ShippingScheduleType::class)->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
        ;
    }
}
