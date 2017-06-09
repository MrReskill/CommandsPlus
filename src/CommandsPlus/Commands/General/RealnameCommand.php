<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;
use CommandsPlus\BaseFiles\Profile;

class RealnameCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("realname", "Allows you to see a player's real username.", "/realname <player>");
        $this->setPermission("commandsplus.command.realname");
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
            
        $profile = new Profile($player);
        if($profile->isNicknamed())
        {
            $player->sendMessage("§cThat player is not nicknamed.");
            return false;
        }
        
        $sender->sendMessage("§7".$args[0]."'s realname is: ".$player->getName()."!");
        return true;
    }
}
