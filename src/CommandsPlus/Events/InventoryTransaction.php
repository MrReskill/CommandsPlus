<?php

namespace CommandsPlus\Events;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\inventory\PlayerInventory;
use CommandsPlus\Main;

class InventoryTransaction extends PluginBase implements Listener
{

    public function onInventoryTransaction(InventoryTransactionEvent $event)
    {
        $transactions = $event->getTransaction()->getTransactions();
        foreach($transactions as $transaction)
        {
            $inventory = $transaction->getInventory();
            if($inventory->getName() === "Chest" || $inventory->getName() === "Player")
            {
                $block = $inventory->getHolder();
                $location = $block->getX().":".$block->getY().":".$block->getZ().":".$block->getLevel()->getName();
                if(in_array($location, Main::getInstance()->getAPI()->invsees)) $event->setCancelled(true);
            }
        }
    }
}
