<?php

namespace CommandsPlus\Commands\Spawn;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;

class SpawnCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("spawn", "Teleports you to spawn.", "/spawn");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$sender instanceof Player) return false;
        
        if(isset($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $sender->teleport($sender->getServer()->getDefaultLevel()->getSafeSpawn());
        $sender->sendMessage("§7Welcome to the spawn!");
        return true;
    }
}
