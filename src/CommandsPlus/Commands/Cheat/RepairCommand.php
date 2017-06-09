<?php

namespace CommandsPlus\Commands\Cheat;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use pocketmine\item\{Tool, Armor};

class RepairCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("repair", "Repairs the durability of all or one item.", "/repair <hand/all>", ["fix"]);
        $this->setPermission("commandsplus.command.repair");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) !== 1 || (strtolower($args[0]) !== "hand" && strtolower($args[0]) !== "all"))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $target = strtolower($args[0]);        
        if($target === "all")
        {
            foreach($sender->getInventory()->getContents() as $item)
            {
                if($item instanceof Tool) $item->setDamage(0);
            }
            foreach($sender->getInventory()->getArmorContents() as $item)
            {
                if($item instanceof Armor) $item->setDamage(0);
            }
            $message = "§7All of your items have been repaired!";
        }
        else
        {
            $item = $sender->getInventory()->getItemInHand();
            if(!$item instanceof Tool && !$item instanceof Armor)
            {
                $sender->sendMessage("§cThe item in your hand cannot be repaired.");
                return false;
            }
            $item->setDamage(0);
            $message = "§7This item has been repaired!";
        }
        
        $sender->sendMessage($message);
        return true;
    }
}
