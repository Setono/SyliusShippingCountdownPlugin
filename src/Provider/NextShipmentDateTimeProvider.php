<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Provider;

use DateTimeInterface;
use Safe\DateTime;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingScheduleInterface;
use Setono\SyliusShippingCountdownPlugin\Repository\ShippingScheduleRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;

final class NextShipmentDateTimeProvider implements NextShipmentDateTimeProviderInterface
{
    private ShippingScheduleRepositoryInterface $repository;

    public function __construct(ShippingScheduleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getNextShipmentDateTime(ChannelInterface $channel, DateTimeInterface $at = null, int $searchDaysLimit = 10): ?DateTimeInterface
    {
        if ($searchDaysLimit-- <= 0) {
            return null;
        }

        if (null === $at) {
            $at = new DateTime('now');
        }

        $schedule = $this->repository->findForChannelAndDate($channel, $at);
        if (null === $schedule || ShippingScheduleInterface::NO_SHIPPING === $schedule->getShipAt()) {
            // If there are no shipping at this day - check next day at loop
            return $this->getNextShipmentDateTime(
                $channel,
                $this->getNextDayDateFromDateTime($at),
                $searchDaysLimit
            );
        }

        /** @psalm-suppress PossiblyNullArgument */
        $nextShipmentDateTime = $this->getDateTime($at, $schedule->getShipAt());
        if ($nextShipmentDateTime <= $at) {
            // If today's shipping already was performed - search
            // next shipment date starting from tomorrow's 00:00:00
            return $this->getNextShipmentDateTime(
                $channel,
                $this->getNextDayDateFromDateTime($at),
                $searchDaysLimit
            );
        }

        return $nextShipmentDateTime;
    }

    private function getDateTime(DateTimeInterface $date, DateTimeInterface $time): DateTimeInterface
    {
        $dateTimeString = $date->format(sprintf(
            'Y-m-d %s',
            $time->format('H:i')
        ));

        return DateTime::createFromFormat('Y-m-d H:i', $dateTimeString);
    }

    private function getNextDayDateFromDateTime(DateTimeInterface $datetime): DateTimeInterface
    {
        $dateString = $datetime->format('Y-m-d 24:00:00');

        return DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
    }
}
