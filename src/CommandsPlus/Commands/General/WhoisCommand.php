<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use CommandsPlus\Main;

class WhoisCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("whois", "Displays player information.", "/whois <player>");
        $this->setPermission("commandsplus.command.whois");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)) return false;
        
        if(count($args) !== 1)
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        if(!($player = Main::getInstance()->getAPI()->getPlayer($args[0])))
        {
            $sender->sendMessage("§cThat player cannot be found.");;
            return false;
        }
        
        $sender->sendMessage("§7".$player->getDisplayName()."'s informations :");
        $sender->sendMessage("§7* Name: ".$player->getName());
        if($sender->hasPermission("commandsplus.command.whois.extra"))
        {
            $sender->sendMessage("§7* IP: ".$player->getAddress());
            $sender->sendMessage("§7* Port: ".$player->getPort());
            $sender->sendMessage("§7* Client ID: ".$player->getClientID());
        }
        $sender->sendMessage("§7* Gamemode: ".$player->getGamemode());
        $sender->sendMessage("§7* Position: ".round($player->getX()).":".round($player->getY()).":".round($player->getZ()));
        return true;
    }
}
