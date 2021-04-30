<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusShippingCountdownPlugin\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\SyliusShippingCountdownPlugin\DependencyInjection\Configuration;
use Setono\SyliusShippingCountdownPlugin\Form\Type\ShippingScheduleType;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingSchedule;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingScheduleInterface;
use Setono\SyliusShippingCountdownPlugin\Repository\ShippingScheduleRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function values_are_invalid_if_required_value_is_not_provided(): void
    {
        $this->assertConfigurationIsValid(
            [
                [],
            ],
        );
    }

    /**
     * @test
     */
    public function processed_configuration_for_array_node_1(): void
    {
        $this->assertProcessedConfigurationEquals([
            'setono_sylius_shipping_countdown' => [],
        ], [
            'driver' => SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
            'resources' => [
                'shipping_schedule' => [
                    'classes' => [
                        'interface' => ShippingScheduleInterface::class,
                        'model' => ShippingSchedule::class,
                        'controller' => ResourceController::class,
                        'repository' => ShippingScheduleRepository::class,
                        'factory' => Factory::class,
                        'form' => ShippingScheduleType::class,
                    ],
                ],
            ],
        ]);
    }
}
