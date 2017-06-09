<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\BaseFiles\Profile;
use CommandsPlus\Main;

class NickCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("nick", "Change your display name.", "/nick <nick/off>", ["nickname"]);
        $this->setPermission("commandsplus.command.nick");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) !== 1)
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $profile = new Profile($sender);
        if($args[0] === "off")
        {
            if(!$profile->isNicknamed())
            {
                $sender->sendMessage("§cYou are not nicknamed.");
                return false;
            }
            $profile->removeNickname();
            $sender->sendMessage("§7Your identity has been restored!");
            return true;
        }
        elseif(!preg_match("#^[a-z0-9]+$#i", $args[0]) || in_array(strtolower($args[0]), Main::getInstance()->getAPI()->nicks))
        {
            $sender->sendMessage("§cYou cannot choose this nickname.");
            return false;
        }
        
        if($profile->isNicknamed())
        {
            $sender->sendMessage("§cYou are already nicknamed.");
            return false;
        }
        
        $profile->setNickname($args[0]);
        $sender->sendMessage("§7You became someone else...");
        return true;
    }
}
