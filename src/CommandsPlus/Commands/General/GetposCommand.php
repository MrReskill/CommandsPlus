<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;

class GetposCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("getpos", "Displays the current coordinate location in the world of a player.", "/getpos <player>", ["coords", "position", "whereami", "getlocation", "getloc"]);
        $this->setPermission("commandsplus.command.getpos");
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
        
        $message = ($player !== $sender) ? "§7".$player->getDisplayName()."'s" : "§7Your";
        $sender->sendMessage($message." coordinates are :");
        $sender->sendMessage("§7* X: ".round($player->getX())." Y: ".round($player->getY())." Z: ".round($player->getZ()));
        $sender->sendMessage("§7* Level: ".$player->getLevel()->getName());
        return true;
    }
}
