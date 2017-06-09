<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;

class HelpopCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("helpop", "Requests help from online staff.", "/helpop <message...>", ["amsg", "ac"]);
        $this->setPermission("commandsplus.command.helpop");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(empty($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        foreach($sender->getServer()->getOnlinePlayers() as $player)
        {
            if($player->hasPermission("commandsplus.command.helpop.receive")) $player->sendMessage("§7(Help) ".$sender->getDisplayName().": ".implode(" ", $args));
        }
        
        $sender->sendMessage("§7Your request help has been sent!");
        return true;
    }
}
