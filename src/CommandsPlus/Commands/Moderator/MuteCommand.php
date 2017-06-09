<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;
use CommandsPlus\BaseFiles\Profile;

class MuteCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("mute", "Mutes a specified player.", "/mute <player> <minute(s)>", ["silence"]);
        $this->setPermission("commandsplus.command.mute");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)) return false;
        
        if(count($args) !== 2 || !is_numeric($args[1])) // TODO: Making a real time system with days/hours/minutes..
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        if(!($player = Main::getInstance()->getAPI()->getPlayer($args[0])))
        {
            $sender->sendMessage("§cThat player cannot be found.");
            return false;
        }
        
        $profile = new Profile($player);
        if($profile->isMute())
        {
            $sender->sendMessage("§cThat player is already muted.");
            return false;
        }
        
        $profile->setMute($args[1]);
        $sender->sendMessage("§7".$player->getDisplayName()." has been muted during ".$args[1]." minute(s)!");
        $player->sendMessage("§cYou are now muted.");
        return true;
    }
}
