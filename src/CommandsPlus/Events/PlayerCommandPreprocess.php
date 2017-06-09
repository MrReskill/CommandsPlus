<?php

namespace CommandsPlus\Events;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use CommandsPlus\BaseFiles\Profile;

class PlayerCommandPreprocess extends PluginBase implements Listener
{

    public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $event)
    {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $profile = new Profile($player);
        if($profile->isMute())
        {
            if($profile->getMute() > time()) 
            { 
                if($message{0} === "/") 
                {
                    $command = explode(" ", $message);
                    if(!in_array("/register", $command) || !in_array("/login", $command))
                    {   
                        $event->setCancelled(true);
                        $player->sendMessage("§cYou are muted.");
                    }
                }
            }
            else
            {
                $profile->removeMute();
                $player->sendMessage("§7You are no longer muted!");
            }
        }
    }
}
