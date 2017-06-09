<?php

namespace CommandsPlus\Events;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use CommandsPlus\BaseFiles\Profile;

class PlayerDeath extends PluginBase implements Listener
{

    public function onPlayerDeath(PlayerDeathEvent $event)
    {
        $profile = new Profile($event->getPlayer());
        $profile->setLastDeathLocation();
    }
}
