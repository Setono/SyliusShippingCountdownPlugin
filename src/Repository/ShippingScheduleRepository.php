<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Repository;

use DateTimeInterface;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingScheduleInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class ShippingScheduleRepository extends EntityRepository implements ShippingScheduleRepositoryInterface
{
    /**
     * @psalm-suppress MixedInferredReturnType
     */
    public function findForChannelAndDate(ChannelInterface $channel, DateTimeInterface $date): ?ShippingScheduleInterface
    {
        /** @psalm-suppress MixedReturnStatement */
        return $this->createQueryBuilder('o')
            ->andWhere(':channel MEMBER OF o.channels')
            ->andWhere('(o.weekday IS NULL OR o.weekday = :weekday)')
            ->andWhere('(o.startsAt IS NULL OR o.startsAt <= :at) AND (o.endsAt IS NULL OR o.endsAt >= :at)')
            ->setParameters([
                'channel' => $channel,
                'weekday' => $date->format('w'),
                'at' => $date->format('Y-m-d'),
            ])
            ->addOrderBy('o.priority', 'DESC')
            ->addOrderBy('o.weekday', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
