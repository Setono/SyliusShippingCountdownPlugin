<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusShippingCountdownPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusShippingCountdownPlugin\DependencyInjection\SetonoSyliusShippingCountdownExtension;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingSchedule;
use Setono\SyliusShippingCountdownPlugin\Repository\ShippingScheduleRepository;
use Sylius\Component\Resource\Factory\Factory;

final class SetonoSyliusShippingCountdownExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoSyliusShippingCountdownExtension(),
        ];
    }

    protected function getMinimalConfiguration(): array
    {
        return [];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_sylius_shipping_countdown.model.shipping_schedule.class', ShippingSchedule::class);
        $this->assertContainerBuilderHasParameter('setono_sylius_shipping_countdown.repository.shipping_schedule.class', ShippingScheduleRepository::class);
        $this->assertContainerBuilderHasParameter('setono_sylius_shipping_countdown.factory.shipping_schedule.class', Factory::class);
    }
}
