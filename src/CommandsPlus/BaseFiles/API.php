<?php

namespace CommandsPlus\BaseFiles;

use CommandsPlus\Main;
use pocketmine\Player;

class API
{
     
    public $nicks = [];
    public $skins = [];
    public $invsees = [];
    public $backs = [];
    
    private $owner; 
    
    public function __construct(Main $owner)
    {
        $this->owner = $owner;
    }
    
    public function getPlayer(string $name)
    {
        $name = strtolower($name);
        $player = $this->owner->getServer()->getPlayer($name);
        if($player instanceof Player) return $player;
        
        foreach($this->owner->getServer()->getOnlinePlayers() as $player)
        {
            $displayname = strtolower($player->getDisplayName());
            if($displayname === $name) return $player;
            
            if(strlen($displayname) === 1 || strlen($name) === 1) // TODO: Replace these bad lines..
            {
                if($displayname{0} === $name{0}) return $player;
            }
            else
            {
                if($displayname{0} === $name{0} && $displayname{1} === $name{1}) return $player;
            }
        }
        
        return false;
    }
}