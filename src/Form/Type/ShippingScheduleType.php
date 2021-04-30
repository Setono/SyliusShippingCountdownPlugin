<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Form\Type;

use Setono\SyliusShippingCountdownPlugin\Model\ShippingSchedule;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

final class ShippingScheduleType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new AddCodeFormSubscriber())
            ->add('weekday', ChoiceType::class, [
                'label' => 'setono_sylius_shipping_countdown.form.shipping_schedule.weekday',
                'help' => 'setono_sylius_shipping_countdown.form.shipping_schedule.weekday_help',
                'choices' => [
                    'setono_sylius_shipping_countdown.ui.weekdays.any' => ShippingSchedule::WEEKDAY_ANY,
                    'setono_sylius_shipping_countdown.ui.weekdays.monday' => ShippingSchedule::WEEKDAY_MONDAY,
                    'setono_sylius_shipping_countdown.ui.weekdays.tuesday' => ShippingSchedule::WEEKDAY_TUESDAY,
                    'setono_sylius_shipping_countdown.ui.weekdays.wednesday' => ShippingSchedule::WEEKDAY_WEDNESDAY,
                    'setono_sylius_shipping_countdown.ui.weekdays.thursday' => ShippingSchedule::WEEKDAY_THURSDAY,
                    'setono_sylius_shipping_countdown.ui.weekdays.friday' => ShippingSchedule::WEEKDAY_FRIDAY,
                    'setono_sylius_shipping_countdown.ui.weekdays.saturday' => ShippingSchedule::WEEKDAY_SATURDAY,
                    'setono_sylius_shipping_countdown.ui.weekdays.sunday' => ShippingSchedule::WEEKDAY_SUNDAY,
                ],
            ])
            ->add('shipAt', TimeType::class, [
                'label' => 'setono_sylius_shipping_countdown.form.shipping_schedule.ship_at',
                'help' => 'setono_sylius_shipping_countdown.form.shipping_schedule.ship_at_help',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('startsAt', DateType::class, [
                'label' => 'setono_sylius_shipping_countdown.form.shipping_schedule.starts_at',
                'help' => 'setono_sylius_shipping_countdown.form.shipping_schedule.starts_at_help',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endsAt', DateType::class, [
                'label' => 'setono_sylius_shipping_countdown.form.shipping_schedule.ends_at',
                'help' => 'setono_sylius_shipping_countdown.form.shipping_schedule.ends_at_help',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('priority', IntegerType::class, [
                'label' => 'setono_sylius_shipping_countdown.form.shipping_schedule.priority',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_shipping_countdown_shipping_schedule';
    }
}
