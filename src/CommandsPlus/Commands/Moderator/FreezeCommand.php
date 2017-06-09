<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use CommandsPlus\Main;

class FreezeCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("freeze", "Freeze a specific player.", "/freeze <player>");
        $this->setPermission("commandsplus.command.freeze");
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
        
        if($player->isImmobile())
        {
            $sender->sendMessage("§cThat player is already frozen.");
            return false;
        }
        
        $player->setImmobile();
        $sender->sendMessage("§7".$player->getDisplayName()." is now frozen!");
        $player->sendMessage("§cYou are now frozen.");
        return true;
    }
}
