<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;

class ExtCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("ext", "Extinguish a player.", "/ext <player>", ["extinguish"]);
        $this->setPermission("commandsplus.command.ext");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
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
        
        if(!$player->isOnFire())
        {
            $sender->sendMessage("§cThat player is not on fire.");;
            return false;
        }
        
        $player->extinguish();
        $sender->sendMessage("§7".$player->getDisplayName()." is no longer on fire!");
        return true;
    }
}
