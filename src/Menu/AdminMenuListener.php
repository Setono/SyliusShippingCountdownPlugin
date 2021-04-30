<?php

declare(strict_types=1);

namespace Setono\SyliusShippingCountdownPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $this->addChild($menu);
    }

    private function addChild(ItemInterface $menu): void
    {
        $submenu = $menu->getChild('configuration');
        $item = $submenu instanceof ItemInterface ? $submenu : $menu->getFirstChild();
        $item
            ->addChild('shipping_schedule', [
                'route' => 'setono_sylius_shipping_countdown_admin_shipping_schedule_index',
            ])
            ->setLabel('setono_sylius_shipping_countdown.menu.admin.main.configuration.shipping_schedule')
            ->setLabelAttribute('icon', 'calendar')
        ;
    }
}
