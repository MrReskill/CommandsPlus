<?php

namespace CommandsPlus\BaseFiles;

use pocketmine\Player;
use CommandsPlus\Main;

class Profile
{
    
    private $player;
    private $name;
    private $mutes;
    private $skins;
    private $nicks;
    private $backs;
    
    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->name = $player->getName();
        $this->mutes = Main::getInstance()->mutes;
        $this->skins = Main::getInstance()->getAPI()->skins;
        $this->nicks = Main::getInstance()->getAPI()->nicks;
        $this->backs = Main::getInstance()->getAPI()->backs;
    }
    
    /*
     *
     *  _______   _______   _______   _______
     * |       | |       | |       | |   |   |
     * |       | |       | |    ___| |   |  /
     * |   ___/  |       | |   |     |     /
     * |      \  |       | |   |___  |     \
     * |       | |   |   | |       | |   |  \
     * |_______| |___|___| |_______| |___|___|
     *
     *
    */
    
    public function getLastDeathLocation() : array
    {
        return explode(" ", $this->backs[$this->name]);
    }
      
    public function isDead() : bool
    {
        return isset($this->backs[$this->name]);
    }
    
    public function removeLastDeathLocation()
    {
        unset(Main::getInstance()->getAPI()->backs[$this->name]);
    }
    
    public function setLastDeathLocation()
    {
        Main::getInstance()->getAPI()->backs[$this->name] = $this->player->getX().":".$this->player->getY().":".$this->player->getZ().":".$this->player->getLevel()->getName();
    } 
    
    /*
     *
     *  ___  ___   _______   _______   _______ 
     * |   \|   | |       | |       | |   |   |
     * |    |   | |_     _| |    ___| |   |  /
     * |        |   |   |   |   |     |     /
     * |        |  _|   |_  |   |___  |     \
     * |   |    | |       | |       | |   |  \
     * |__/|____| |_______| |_______| |___|___| 
     *
     *
    */
    
    public function getNickname() : string
    {
        return $this->player->getDisplayName();
    }
    
    public function getOriginSkin() : array
    {
        return $this->skins[$this->name] ?? [];
    }
    
    public function isNicknamed() : bool
    {
        return isset($this->skins[$this->name]);
    } 
    
    public function removeNickname()
    {
        $this->player->setDisplayName($this->name);
        $this->player->setNametag($this->name);
        unset(Main::getInstance()->getAPI()->nicks[array_search($this->player->getDisplayName(), Main::getInstance()->getAPI()->nicks)]);
        
        $skin = $this->getOriginSkin();
        $this->player->despawnFromAll();
        $this->player->setSkin($skin[0], $skin[1]);
        $this->player->spawnToAll();
        unset(Main::getInstance()->getAPI()->skins[$this->name]);
    }
    
    public function setNickname(string $nickname)
    {
        $this->player->setDisplayName($nickname);
        $this->player->setNameTag($nickname);
        array_push(Main::getInstance()->getAPI()->nicks, strtolower($nickname));
        
        $players = Main::getInstance()->getServer()->getOnlinePlayers();
        $selected = $players[array_rand($players)]; // TODO: Do not give the skin of $this->player.
        Main::getInstance()->getAPI()->skins[$this->name] = [$this->player->getSkinData(), $this->player->getSkinId()];
        $this->player->despawnFromAll();
        $this->player->setSkin($selected->getSkinData(), $selected->getSkinId());
        $this->player->spawnToAll();
    }
    
    /*
     *
     *  ___   ___   _______   _______   _______
     * |   \_/   | |   |   | |       | |       |
     * |         | |   |   | |_     _| |    ___|
     * |         | |   |   |   |   |   |      |
     * |  |\_/|  | |   |   |   |   |   |    __|
     * |  |   |  | |       |   |   |   |       |
     * |__|   |__| |_______|   |___|   |_______|
     *
     *
    */
    
    public function getMute() : int
    {
        return $this->mutes->get($this->name);
    }
    
    public function isMute() : bool
    {
        return ($this->mutes->get($this->name, null) !== null) ? true : false;
    }
    
    public function removeMute()
    {
        $this->mutes->remove($this->name);
        $this->mutes->save();
    }

    public function setMute(int $minutes)
    {
        $this->mutes->set($this->name, time() + $minutes * 60);
        $this->mutes->save();
    }
}
