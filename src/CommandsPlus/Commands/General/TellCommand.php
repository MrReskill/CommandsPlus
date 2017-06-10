<?php

namespace CommandsPlus\Commands\General;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;
use CommandsPlus\BaseFiles\Profile;

class TellCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("tell", "This allows you to private message another player.", "/tell <player> <message...>", ["w", "msg"]);
        $this->setPermission("commandsplus.command.tell");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) < 2)
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        if(!($player = Main::getInstance()->getAPI()->getPlayer($args[0])))
        {
            $sender->sendMessage("§cThat player cannot be found.");;
            return false;
        }
        
        if($player === $sender)
        {
            $sender->sendMessage("§cYou can't send a private message to yourself.");;
            return false;
        }
        
        array_shift($args);
        foreach($sender->getServer()->getOnlinePlayers() as $p)
        {
            $profile = new Profile($p);
            if($profile->isSocialspy())
            {
                $p->sendMessage("§7[".$sender->getDisplayName()." -> ".$player->getDisplayName()."] ".implode(" ", $args));
            }
        }
        $sender->sendMessage("§7[You -> ".$player->getDisplayName()."] ".implode(" ", $args));
		$player->sendMessage("§7[".$sender->getDisplayName()." -> You] ".implode(" ", $args));
        return true;
    }
}
