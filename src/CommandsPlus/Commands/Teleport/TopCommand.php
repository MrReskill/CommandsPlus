<?php

namespace CommandsPlus\Commands\Teleport;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use pocketmine\math\Vector3;

class TopCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("top", "Teleports you to the highest block at your current location.", "/top");
        $this->setPermission("commandsplus.command.top");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(isset($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $sender->teleport(new Vector3($sender->getX(), $sender->getLevel()->getHighestBlockAt($sender->getX(), $sender->getZ()) + 1, $sender->getZ()));
        $sender->sendMessage("§7You have been teleported to the highest block at your current location!");
        return true;
    }
}
