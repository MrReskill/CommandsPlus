<?php

namespace CommandsPlus\Commands\Teleport;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\BaseFiles\Profile;
use pocketmine\level\Position;

class BackCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("back", "Returns you to your last position from a prior teleport.", "/back", ["return"]);
        $this->setPermission("commandsplus.command.back");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(isset($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $profile = new Profile($sender);
        if($profile->isDead())
        {
            $sender->sendMessage("§cYou are not dead.");
            return false;
        }
    
        $location = $profile->getLastDeathLocation();
        $sender->teleport(new Position(intval($location[0]), intval($location[1]), intval($location[2]), $sender->getServer()->getLevelByName($location[3])));
        $profile->removeLastDeathLocation();
        $sender->sendMessage("§7You have been teleported to your last death location!");
        return true;
    }
}
