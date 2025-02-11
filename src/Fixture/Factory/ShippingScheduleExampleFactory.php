<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Fixture\Factory;

use DateTimeInterface;
use Setono\SyliusShippingCountdownPlugin\Model\ShippingScheduleInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

/* not final */ class ShippingScheduleExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var RepositoryInterface */
    protected $channelRepository;

    /** @var FactoryInterface */
    protected $shippingScheduleFactory;

    /** @var \Faker\Generator */
    protected $faker;

    /** @var OptionsResolver */
    protected $optionsResolver;

    public function __construct(
        RepositoryInterface $channelRepository,
        FactoryInterface $shippingScheduleFactory
    ) {
        $this->channelRepository = $channelRepository;
        $this->shippingScheduleFactory = $shippingScheduleFactory;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): ShippingScheduleInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var ShippingScheduleInterface $shippingSchedule */
        $shippingSchedule = $this->shippingScheduleFactory->createNew();

        /** @psalm-suppress MixedArgument */
        $shippingSchedule->setCode($options['code']);

        /** @psalm-suppress MixedArgument */
        $shippingSchedule->setWeekday($options['weekday']);

        if (isset($options['ship_at'])) {
            /** @psalm-suppress MixedArgument */
            $shippingSchedule->setShipAt($options['ship_at']);
        }

        if (isset($options['starts_at'])) {
            /** @psalm-suppress MixedArgument */
            $shippingSchedule->setStartsAt($options['starts_at']);
        }

        if (isset($options['ends_at'])) {
            /** @psalm-suppress MixedArgument */
            $shippingSchedule->setEndsAt($options['ends_at']);
        }

        $this->createRelations($shippingSchedule, $options);

        /** @psalm-suppress MixedArgument */
        $shippingSchedule->setPriority($options['priority']);

        return $shippingSchedule;
    }

    private function createRelations(ShippingScheduleInterface $shippingSchedule, array $options): void
    {
        /** @var ChannelInterface $channel */
        foreach ($options['channels'] as $channel) {
            $shippingSchedule->addChannel($channel);
        }
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('code', function (): string {
                return $this->faker->uuid;
            })

            ->setDefined('weekday')
            ->setAllowedValues('weekday', [
                null,
                ShippingScheduleInterface::WEEKDAY_MONDAY,
                ShippingScheduleInterface::WEEKDAY_TUESDAY,
                ShippingScheduleInterface::WEEKDAY_WEDNESDAY,
                ShippingScheduleInterface::WEEKDAY_THURSDAY,
                ShippingScheduleInterface::WEEKDAY_FRIDAY,
                ShippingScheduleInterface::WEEKDAY_SATURDAY,
                ShippingScheduleInterface::WEEKDAY_SUNDAY,
            ])

            ->setDefault('ship_at', null)
            ->setAllowedTypes('ship_at', ['null', 'string', DateTimeInterface::class])
            ->setNormalizer('ship_at', $this->getDateTimeNormalizer())

            ->setDefault('starts_at', null)
            ->setAllowedTypes('starts_at', ['null', 'string', DateTimeInterface::class])
            ->setNormalizer('starts_at', $this->getDateTimeNormalizer())

            ->setDefault('ends_at', null)
            ->setAllowedTypes('ends_at', ['null', 'string', DateTimeInterface::class])
            ->setNormalizer('ends_at', $this->getDateTimeNormalizer())

            ->setDefault('channels', LazyOption::randomOnes($this->channelRepository, 1))
            ->setAllowedTypes('channels', 'array')
            ->setNormalizer('channels', LazyOption::findBy($this->channelRepository, 'code'))

            ->setDefault('priority', 0)
            ->setAllowedTypes('priority', ['int'])
        ;
    }

    protected function getDateTimeNormalizer(): \Closure
    {
        /**
         * @psalm-suppress UnusedClosureParam
         * @psalm-suppress MissingClosureParamType
         */
        return function (Options $options, $previousValue): ?DateTimeInterface {
            if (null === $previousValue) {
                return $previousValue;
            }

            if ($previousValue instanceof DateTimeInterface) {
                return $previousValue;
            }

            Assert::string($previousValue);

            return new \DateTime($previousValue);
        };
    }
}
