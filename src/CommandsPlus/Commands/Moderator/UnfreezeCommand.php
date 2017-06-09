<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use CommandsPlus\Main;

class UnfreezeCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("unfreeze", "Unfreeze a player who is immobile.", "/unfreeze <player>");
        $this->setPermission("commandsplus.command.unfreeze");
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
        
        if(!$player->isImmobile())
        {
            $sender->sendMessage("§cThat player is not frozen.");
            return false;
        }
        
        $player->setImmobile(false);
        $sender->sendMessage("§7".$player->getDisplayName()." is no longer frozen!");
        $player->sendMessage("§7You are no longer frozen!");
        return true;
    }
}
