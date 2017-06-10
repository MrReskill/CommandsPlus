<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\BaseFiles\Profile;

class SocialspyCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("socialspy", "See other players private messages.", "/socialspy");
        $this->setPermission("commandsplus.command.socialspy");
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
        if($profile->isSocialspy())
        {
            $sender->sendMessage("§cYou are already a social spy.");;
            return false;
        }
        
        $profile->setSocialspy();
        $sender->sendMessage("§7You are become a social spy!");
        return true;
    }
}
