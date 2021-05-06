<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Provider;

use DateTimeInterface;
use Sylius\Component\Core\Model\ChannelInterface;

interface NextShipmentDateTimeProviderInterface
{
    public function getNextShipmentDateTime(ChannelInterface $channel, DateTimeInterface $at = null, int $searchDaysLimit = 10): ?DateTimeInterface;
}
