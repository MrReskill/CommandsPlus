<?php

namespace CommandsPlus\Commands\Cheat;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;

class FeedCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("feed", "Satisfy the hunger.", "/feed <player>", ["eat"]);
        $this->setPermission("commandsplus.command.feed");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) > 1)
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $player = $sender;
        if(isset($args[0]))
        {
            if(!($player = Main::getInstance()->getAPI()->getPlayer($args[0])))
            {
                $sender->sendMessage("§cThat player cannot be found.");;
                return false;
            }
        }
        
        $player->setFood($player->getMaxFood());
        $player->sendMessage("§7You have been fed!");
        if($player !== $sender) $sender->sendMessage("§7".$player->getDisplayName()." has been fed!");
        return true;
    }
}
