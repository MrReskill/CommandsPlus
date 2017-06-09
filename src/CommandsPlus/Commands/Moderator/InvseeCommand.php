<?php

namespace CommandsPlus\Commands\Moderator;

use pocketmine\command\{Command, CommandSender};
use pocketmine\Player;
use CommandsPlus\Main;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\nbt\tag\{CompoundTag, ListTag, StringTag, IntTag};
use pocketmine\tile\Tile;
use pocketmine\nbt\NBT;

class InvseeCommand extends Command
{
    
    public function __construct()
    {
        parent::__construct("invsee", "See the inventory of other players.", "/invsee <player>");
        $this->setPermission("commandsplus.command.invsee");
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
        
        if($sender->getLevel()->getBlockIdAt($sender->getX(), $sender->getY() + 2, $sender->getZ()) !== 0)
        {
            $sender->sendMessage("§cYou have to be in an area where the block above you is air.");;
            return false;  
        }
        
        $air = $sender->getLevel()->getBlock(new Vector3($sender->getX(), $sender->getY() + 2, $sender->getZ()));
        $sender->getServer()->getDefaultLevel()->setBlock(new Vector3($air->getX(), $air->getY(), $air->getZ()), Block::get(54));
        $nbt = new CompoundTag("", [new ListTag("Items", []), new StringTag("id", Tile::CHEST), new IntTag("x", $air->getX()), new IntTag("y", $air->getY()), new IntTag("z", $air->getZ())]);
        $nbt->Items->setTagType(NBT::TAG_Compound);
        $chest = Tile::createTile("Chest", $sender->getServer()->getDefaultLevel(), $nbt);
        foreach($player->getInventory()->getContents() as $item) $chest->getInventory()->addItem($item);
        array_push(Main::getInstance()->getAPI()->invsees, $chest->getX().":".$chest->getY().":".$chest->getZ().":".$chest->getLevel()->getName());
        //$sender->addWindow($chest->getInventory());
        $sender->sendMessage("§7A chest is appeared above you, ".$player->getDisplayName()."'s inventory has been copied into it!");
        return true;
    }
}
