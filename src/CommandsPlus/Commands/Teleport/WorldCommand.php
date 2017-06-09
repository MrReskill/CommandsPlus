<?php

namespace CommandsPlus\Commands\Teleport;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;

class WorldCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("world", "Allows you to teleport to different world.", "/world <worldname>");
        $this->setPermission("commandsplus.command.world");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) !== 1)
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        if(!$sender->getServer()->isLevelGenerated($args[0]))
        {
            $sender->sendMessage("§cThis level does not exist.");
            return false;
        }
        
        if(!$sender->getServer()->isLevelLoaded($args[0])) $sender->getServer()->loadLevel($args[0]);
        $sender->teleport($sender->getServer()->getLevelByName($args[0])->getSpawnLocation());
        $sender->sendMessage("§7You have been teleported in the world ".$args[0]."!");
        return true;
    }
}
