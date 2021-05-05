<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/* not final */ class ShippingScheduleFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'setono_sylius_shipping_countdown_shipping_schedule';
    }

    protected function configureResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $node = $resourceNode->children();
        $node->scalarNode('code')->cannotBeEmpty();
        $node->scalarNode('weekday')->defaultNull();
        $node->scalarNode('ship_at')->defaultNull();
        $node->scalarNode('starts_at')->defaultNull();
        $node->scalarNode('ends_at')->defaultNull();
        $node->arrayNode('channels')->scalarPrototype();
        $node->integerNode('priority')->defaultValue(0);
    }
}
