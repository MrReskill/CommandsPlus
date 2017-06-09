<?php

namespace CommandsPlus\Events;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use CommandsPlus\BaseFiles\Profile;

class PlayerChat extends PluginBase implements Listener
{

    public function onPlayerChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        $profile = new Profile($player);
        if($profile->isMute())
        {
            if($profile->getMute() > time()) 
            {
                $event->setCancelled(true);
                $player->sendMessage("§cYou are muted.");
            }
            else
            {
                $profile->removeMute();
                $player->sendMessage("§7You are no longer muted!");
            }
        }
    }
}
