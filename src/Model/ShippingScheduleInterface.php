<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Model;

use DateTimeInterface;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ShippingScheduleInterface extends ResourceInterface, CodeAwareInterface
{
    public const NO_SHIPPING = null;

    public const WEEKDAY_ANY = null;

    public const WEEKDAY_SUNDAY = 0;

    public const WEEKDAY_MONDAY = 1;

    public const WEEKDAY_TUESDAY = 2;

    public const WEEKDAY_WEDNESDAY = 3;

    public const WEEKDAY_THURSDAY = 4;

    public const WEEKDAY_FRIDAY = 5;

    public const WEEKDAY_SATURDAY = 6;

    public function getWeekday(): ?int;

    public function setWeekday(?int $weekday): void;

    public function getShipAt(): ?DateTimeInterface;

    public function setShipAt(?DateTimeInterface $shipAt): void;

    public function getStartsAt(): ?DateTimeInterface;

    public function setStartsAt(?DateTimeInterface $startsAt): void;

    public function getEndsAt(): ?DateTimeInterface;

    public function setEndsAt(?DateTimeInterface $endsAt): void;

    public function getPriority(): int;

    public function setPriority(int $priority): void;
}
