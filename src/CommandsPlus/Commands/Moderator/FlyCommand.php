<?php
namespace CommandsPlus\Commands\Moderation;
use pocketmine\command\{Command, CommandSender};
use CommandsPlus\Main;
class FlyCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("fly", "Use fly on your server", "/fly");
        $this->setPermission("commandsplus.command.fly");
    }
    
    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)) return false;
        if($sender->getAllowFlight() == true){
          $sender->setAllowFlight(false);
          $sender->sendMessage("§6Vous venez de désactivé le §efly");
        } else {
          $sender->setAllowFlight(true);
          $sender->sendMessage("§2Vous venez d'activé le §afly");     
        }
        return true;
    }
}
