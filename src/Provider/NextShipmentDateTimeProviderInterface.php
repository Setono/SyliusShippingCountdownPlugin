<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Provider;

use DateTimeInterface;

interface NextShipmentDateTimeProviderInterface
{
    public function getNextShipmentDateTime(DateTimeInterface $at = null, int $searchDaysLimit = 10): ?DateTimeInterface;
}
