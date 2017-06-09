<?php

namespace CommandsPlus\Commands\Cheat;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;

class MoreCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("more", "Fills the item stack in hand to maximum size.", "/more");
        $this->setPermission("commandsplus.command.more");
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
            $sender->sendMessage("§cThe item in your hand cannot be filled.");
            return false;
        }
        
        $item->setCount($item->getMaxStackSize());
        $sender->sendMessage("§7This item has been filled!");
        return true;
    }
}
