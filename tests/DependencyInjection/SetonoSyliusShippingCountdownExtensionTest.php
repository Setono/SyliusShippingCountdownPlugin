<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusShippingCountdownPlugin\DependencyInjection;

use Setono\SyliusShippingCountdownPlugin\DependencyInjection\SetonoSyliusShippingCountdownExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * See examples of tests and configuration options here: https://github.com/SymfonyTest/SymfonyDependencyInjectionTest
 */
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
        return [
            'option' => 'option_value',
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_sylius_shipping_countdown.option', 'option_value');
    }
}
