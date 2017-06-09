<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};

class KickallCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("kickall", "Kicks all players off the server.", "/kickall <reason...>");
        $this->setPermission("commandsplus.command.kickall");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)) return false;
        
        if(empty($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $reason = implode(" ", $args);
        foreach($sender->getServer()->getOnlinePlayers() as $player)
        {
            if($player->getName() !== $sender->getName()) $player->kick($reason, false);
        }
        
        $sender->sendMessage("§7You have kicked all players for ".$reason."!");
        return true;
    }
}
