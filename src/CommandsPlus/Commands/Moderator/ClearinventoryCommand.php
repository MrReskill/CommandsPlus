<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;

class ClearinventoryCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("clearinventory", "Clear a player's inventory.", "/clearinventory <player>", ["ci", "clean", "clearinvent"]);
        $this->setPermission("commandsplus.command.clear");
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
        
        $player->getInventory()->clearAll();
        $player->sendMessage("§7Your inventory has been cleared!");
        if($player !== $sender) $sender->sendMessage("§7".$player->getDisplayName()."'s inventory has been cleared!");
        return true;
    }
}
