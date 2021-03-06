<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Twig;

use DateTimeInterface;
use Setono\SyliusShippingCountdownPlugin\Provider\NextShipmentDateTimeProviderInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ShippingCountdownExtension extends AbstractExtension
{
    private NextShipmentDateTimeProviderInterface $nextShipmentDateTimeProvider;

    public function __construct(NextShipmentDateTimeProviderInterface $nextShipmentDateTimeProvider)
    {
        $this->nextShipmentDateTimeProvider = $nextShipmentDateTimeProvider;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setono_shipping_countdown_next_shipment_date', function (ChannelInterface $channel): ?DateTimeInterface {
                return $this->nextShipmentDateTimeProvider->getNextShipmentDateTime($channel);
            }),
            new TwigFunction('setono_shipping_countdown_next_shipment_date_rfc2822', function (ChannelInterface $channel): ?string {
                $nextShipmentDateTime = $this->nextShipmentDateTimeProvider->getNextShipmentDateTime($channel);
                if (null === $nextShipmentDateTime) {
                    return null;
                }

                return $nextShipmentDateTime->format(DateTimeInterface::RFC2822);
            }),
        ];
    }
}
