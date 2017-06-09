<?php

namespace CommandsPlus\Commands\Cheat;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommansPlus\Main;

class HealCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("heal", "Heal a player.", "/heal <player>");
        $this->setPermission("commandsplus.command.heal");
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
        
        $player->setHealth($player->getMaxHealth());
        $player->sendMessage("§7You have been healed!");
        if($player !== $sender) $sender->sendMessage("§7".$player->getDisplayName()." has been healed!");
        return true;
    }
}
