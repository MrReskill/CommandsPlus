<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;

class BurnCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("burn", "Sets a player on fire.", "/burn <player> <seconds>");
        $this->setPermission("commandsplus.command.burn");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) !== 2 || !is_numeric($args[1]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        if(!($player = Main::getInstance()->getAPI()->getPlayer($args[0])))
        {
            $sender->sendMessage("§cThat player cannot be found.");;
            return false;
        }
        
        $player->setOnFire($args[1]);
        $sender->sendMessage("§7".$player->getDisplayName()." is now on fire!");
        return true;
    }
}
