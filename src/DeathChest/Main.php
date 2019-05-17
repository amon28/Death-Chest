<?php
namespace DeathChest;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\Item;
use pocketmine\inventory\Inventory;
use pocketmine\tile\Chest;
use pocketmine\tile\Tile;
use pocketmine\nbt\NBT;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\level\Position;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }
    
	public function chest(Player $sender){
    
    $level = $sender->getPosition();
    $world = $sender->getLevel();
    $block = Block::get(Block::CHEST);
    $x = ((int)$level->getX());
    $y = ((int)$level->getY());
    $z = ((int)$level->getZ());
    $world->setBlock(new Vector3($x,$y,$z),$block);
    $world->setblock(new Vector3($x+1,$y,$z),$block);
    
    $nbt = Chest::createNBT(new Vector3($x,$y,$z));
    $nbt2 = Chest::createNBT(new Vector3($x+1,$y,$z));
    $tile = Tile::createTile(Tile::CHEST, $world, $nbt);
    $tile2 = Tile::createTile(Tile::CHEST, $world, $nbt2);
    
    $tile->pairwith($tile2);
    $tile2->pairwith($tile);
    if($tile instanceOf Chest){
    $item = $sender->getInventory()->getContents();
    foreach($item as $i){
    $tile->getInventory()->addItem($i); 
    }
    }


	}
    
    public function onDeath(PlayerDeathEvent $ev){
     $player = $ev->getPlayer();
     $this->chest($player);
}

    public function onDisable(){
     $this->getLogger()->info("§cOffline");
    }
}
