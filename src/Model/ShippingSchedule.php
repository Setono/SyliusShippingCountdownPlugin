<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Model;

use DateTimeInterface;

class ShippingSchedule implements ShippingScheduleInterface
{
    private ?int $id = null;

    private ?string $code = null;

    private ?int $weekday = null;

    private ?DateTimeInterface $shipAt = null;

    private ?DateTimeInterface $startsAt = null;

    private ?DateTimeInterface $endsAt = null;

    protected int $priority = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getWeekday(): ?int
    {
        return $this->weekday;
    }

    public function setWeekday(?int $weekday): void
    {
        $this->weekday = $weekday;
    }

    public function getShipAt(): ?DateTimeInterface
    {
        return $this->shipAt;
    }

    public function setShipAt(?DateTimeInterface $shipAt): void
    {
        $this->shipAt = $shipAt;
    }

    public function getStartsAt(): ?DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(?DateTimeInterface $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): ?DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(?DateTimeInterface $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
