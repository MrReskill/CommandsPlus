<?php

namespace CommandsPlus\Commands\Cheat;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use pocketmine\block\Block;

class BreakCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("break", "Breaks the block you are looking at.", "/break");
        $this->setPermission("commandsplus.command.break");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(isset($args[0]))
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        $block = $sender->getTargetBlock(20);
        if(($block = $sender->getTargetBlock(20)) === null || $block->getId() === 0)
        {
            $sender->sendMessage("§cThere is no block where you are looking.");
            return false;
        }
        
        if($block->getId() === 7)
        {
            $sender->sendMessage("§cBedrock's block cannot be broken.");
            return false;
        }
        
        $sender->getLevel()->setBlock($block, Block::get(0));
        $sender->sendMessage("§7The target block has been broken.");
        return true;
    }
}
