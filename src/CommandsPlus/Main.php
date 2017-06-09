<?php

namespace CommandsPlus;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use CommandsPlus\BaseFiles\API;
use CommandsPlus\Commands\Cheat\{BreakCommand, FeedCommand, HealCommand, MoreCommand, RepairCommand};
use CommandsPlus\Commands\General\{GetposCommand, HelpopCommand, ItemdbCommand, NickCommand, RealnameCommand};
use CommandsPlus\Commands\Moderator\{BurnCommand, ClearinventoryCommand, ExtCommand, InvseeCommand, KickallCommand, MuteCommand};
use CommandsPlus\Commands\Spawn\SpawnCommand;
use CommandsPlus\Commands\Teleport\{BackCommand, TopCommand, TpallCommand, WorldCommand};
use CommandsPlus\Events\{InventoryClose, InventoryTransaction, PlayerChat, PlayerCommandPreprocess, PlayerDeath, PlayerQuit};
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\block\Block;

class Main extends PluginBase implements Listener
{
    const PREFIX = "Commands+";
    
    private static $instance;
    
    private $api;
    
    public function onEnable()
    {
        if(!self::$instance instanceof Main) 
        {
            self::$instance = $this;
            $this->api = new API($this);
        }
        $this->registerEvents();
        $this->registerCommands();
        $this->registerConfigs();
        $this->getLogger()->info(self::PREFIX." enabled...");
    }
    
    public static function getInstance()
    {
        return self::$instance;
    }
    
    public function getAPI()
    {
        return $this->api;
    }
    
    private function registerEvents()
    {
        $events = [new InventoryClose, new InventoryTransaction, new PlayerChat, new PlayerCommandPreprocess, new PlayerDeath, new PlayerQuit, $this];
        foreach($events as $event) $this->getServer()->getPluginManager()->registerEvents($event, $this);
    }
    
    private function registerCommands()
    {
        $commands = ["back" => new BackCommand,
                     "break" => new BreakCommand,
                     "burn" => new BurnCommand, 
                     "clearinventory" => new ClearinventoryCommand, 
                     "ext" => new ExtCommand, 
                     "feed" => new FeedCommand, 
                     "getpos" => new GetposCommand, 
                     "heal" => new HealCommand, 
                     "helpop" => new HelpopCommand, 
                     "invsee" => new InvseeCommand, 
                     "itemdb" => new ItemdbCommand, 
                     "kickall" => new KickallCommand, 
                     "more" => new MoreCommand, 
                     "mute" => new MuteCommand, 
                     "nick" => new NickCommand, 
                     "realname" => new RealnameCommand, 
                     "repair" => new RepairCommand, 
                     "spawn" => new SpawnCommand, 
                     "top" => new TopCommand, 
                     "tpall" => new TpallCommand, 
                     "world" => new WorldCommand];
        foreach($commands as $command => $instance) $this->getServer()->getCommandMap()->register($command, $instance);
    } 
    
    private function registerConfigs()
    {
        if(!file_exists($this->getDataFolder())) mkdir($this->getDataFolder());
        $this->mutes = new Config($this->getDataFolder()."Mutes.yml", Config::YAML, []);
    }
    
    public function onDisable()
    {
        if(count($this->getAPI()->invsees) !== 0)
        {
            foreach($this->getAPI()->invsees as $chest)
            {
                $location = explode(":", $chest);
                $this->getServer()->getLevelByName($location[3])->setBlock(new Vector3(intval($location[0]), intval($location[1]), intval($location[2])), Block::get(0));
            }
        }
    }
}
