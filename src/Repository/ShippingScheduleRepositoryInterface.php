<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Repository;

use DateTimeInterface;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingScheduleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ShippingScheduleRepositoryInterface extends RepositoryInterface
{
    public function findForDate(DateTimeInterface $date): ?ShippingScheduleInterface;
}
