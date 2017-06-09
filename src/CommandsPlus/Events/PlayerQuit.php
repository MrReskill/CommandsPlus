<?php

namespace CommandsPlus\Events;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use CommandsPlus\BaseFiles\Profile;
class PlayerQuit extends PluginBase implements Listener
{

    public function onPlayerQuit(PlayerQuitEvent $event)
    {
        $profile = new Profile($event->getPlayer());
        if($profile->isNicknamed()) $profile->removeNickname();
    }
}
