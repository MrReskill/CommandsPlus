<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use pocketmine\item\{Tool, Armor};

class ItemdbCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("itemdb", "Displays the item informations attached to the item you hold.", "/itemdb");
        $this->setPermission("commandsplus.command.itemdb");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(isset($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $item = $sender->getInventory()->getItemInHand();
        if($item->getId() === 0)
        {
            $sender->sendMessage("§cThe item in your hand has no informations.");
            return false;
        }
        
        $damage = ($item instanceof Tool || $item instanceof Armor) ? "Durability" : "Metadata";
        $sender->sendMessage("§7Item in your hand's informations :");
        $sender->sendMessage("§7* Name: ".$item->getName());
        $sender->sendMessage("§7* ID: ".$item->getId());
        $sender->sendMessage("§7* ".$damage.": ".$item->getDamage());
        $sender->sendMessage("§7* Count: ".$item->getCount());
        return true;
    }
}
