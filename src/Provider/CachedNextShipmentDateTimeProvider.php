<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Provider;

use DateTimeInterface;
use Psr\Cache\CacheItemPoolInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Webmozart\Assert\Assert;

final class CachedNextShipmentDateTimeProvider implements NextShipmentDateTimeProviderInterface
{
    private NextShipmentDateTimeProviderInterface $decorated;

    private CacheItemPoolInterface $cache;

    public function __construct(
        NextShipmentDateTimeProviderInterface $decorated,
        CacheItemPoolInterface $cache
    ) {
        $this->decorated = $decorated;
        $this->cache = $cache;
    }

    public function getNextShipmentDateTime(ChannelInterface $channel, DateTimeInterface $at = null, int $searchDaysLimit = 10): ?DateTimeInterface
    {
        $channelCode = $channel->getCode();
        Assert::notNull($channelCode);
        $cacheKey = sprintf(
            'setono-shipping-countdown-%s',
            $channelCode
        );

        $cacheItem = $this->cache->getItem($cacheKey);
        if (!$cacheItem->isHit()) {
            $nextShipmentDateTime = $this->decorated->getNextShipmentDateTime($channel, $at, $searchDaysLimit);
            $cacheItem->set($nextShipmentDateTime);
            if (null !== $nextShipmentDateTime) {
                // Next shipment datetime become not actual at moment of shipment
                $cacheItem->expiresAt($nextShipmentDateTime);
            } else {
                // If we don't have a schedule - cache for 1 hour
                // So new schedule will be visible in 1 hour
                // after it was added via admin
                $cacheItem->expiresAfter(3600); // @todo FIX to 3600
            }

            $this->cache->save($cacheItem);
        }

        /** @var DateTimeInterface $nextShipmentDateTime */
        $nextShipmentDateTime = $cacheItem->get();

        return $nextShipmentDateTime;
    }
}
