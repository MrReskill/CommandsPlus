<?php

namespace CommandsPlus\Commands\Teleport;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;

class TpallCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("tpall", "Teleports all connected players to you.", "/tpall");
        $this->setPermission("commandsplus.command.tpall");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(isset($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        foreach($sender->getServer()->getOnlinePlayers() as $player)
        {
            if($player->getName() !== $sender->getName()) 
            {
                $player->teleport($sender);
                $player->sendMessage("§7Teleporting to ".$sender->getDisplayName()."...");
            }
        }
        
        $sender->sendMessage("§7You have teleported all players to you!");
        return true;
    }
}
