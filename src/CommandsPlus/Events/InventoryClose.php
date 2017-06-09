<?php

namespace CommandsPlus\Events;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryCloseEvent;
use CommandsPlus\Main;
use pocketmine\math\Vector3;
use pocketmine\block\Block;

class InventoryClose extends PluginBase implements Listener
{

    public function onInventoryClose(InventoryCloseEvent $event)
    {
        $inventory = $event->getInventory();
        if($inventory->getName() === "Chest")
        {
            $viewers = $event->getViewers();
            $block = $inventory->getHolder();
            $location = $block->getX().":".$block->getY().":".$block->getZ().":".$block->getLevel()->getName();
            if(in_array($location, Main::getInstance()->getAPI()->invsees) && count($viewers) === 1)
            {
                $block->getLevel()->setBlock($block, Block::get(0));
                unset(Main::getInstance()->getAPI()->invsees[array_search($location, Main::getInstance()->getAPI()->invsees)]);
            }
        }
    }
}
