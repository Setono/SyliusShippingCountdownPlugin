<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Command;

use Safe\DateTime;
use Setono\SyliusShippingCountdownPlugin\Provider\NextShipmentDateTimeProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class DebugScheduleCommand extends Command
{
    protected static $defaultName = 'setono:shipping-countdown:debug';

    private const DATETIME_FORMAT = 'D, Y-m-d H:i:s P';

    private NextShipmentDateTimeProviderInterface $provider;

    /** @psalm-suppress PropertyNotSetInConstructor */
    private SymfonyStyle $io;

    public function __construct(NextShipmentDateTimeProviderInterface $provider)
    {
        $this->provider = $provider;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('at', InputArgument::OPTIONAL, 'At which datetime?', 'now')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        /** @var string $at */
        $at = $input->getArgument('at');
        $atDateTime = new DateTime($at);

        $this->io->writeln(sprintf(
            'Searching shipment date for %s...',
            $atDateTime->format(self::DATETIME_FORMAT)
        ));

        $nextShipmentDateTime = $this->provider->getNextShipmentDateTime($atDateTime);
        if (null === $nextShipmentDateTime) {
            $this->io->writeln('<error>Next shipment date/time was not found</error>');

            return 1;
        }

        $this->io->writeln(sprintf(
            'Next shipment date/time is: <info>%s</info>',
            $nextShipmentDateTime->format(self::DATETIME_FORMAT)
        ));

        return 0;
    }
}
