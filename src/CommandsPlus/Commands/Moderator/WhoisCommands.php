<?php
namespace CommandsPlus\Commands\Moderator;
use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;
class WhoisCommands extends Command
{
    
    public function __construct()
    {
        parent::__construct("ws", "View player info's.", "/ws <player>", ["whois"]);
        $this->setPermission("commandsplus.command.whois");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender) || !$sender instanceof Player) return false;
        
        if(count($args) !== 1)
        {
            $sender->sendMessage("§cUsage: ".$this->getUsage());
            return false;
        }
        
        if(!($player = Main::getInstance()->getAPI()->getPlayer($args[0])))
        {
            $sender->sendMessage("§cThat player cannot be found.");;
            return false;
        }
        $player = Main::getInstance()->getAPI()->getPlayer($args[0]);
        $sender->sendMessage("§7============");
        $sender->sendMessage("§7> §eIP: ".$player->getAddress());
        $sender->sendMessage("§7> §eLast played: ".$player->getLastPlayed());
        $sender->sendMessage("§7> §eClient ID: ".$player->getClientId());
        $sender->sendMessage("§7> §ePosition: ".round($player->getX()).":".round($player->getY()).":".round($player->getZ()));
        $sender->sendMessage("§7> §eMode: ".$player->getGamemode());
        $sender->sendMessage("§7============");
        return true;
    }
}
