<?php
 
namespace HotshotHD;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\block\Block;

use pocketmine\utils\Config;


class Main extends PluginBase implements Listener {

	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
		"world" => 16
		));
		$this->getLogger()->info("is ready to go!");
	}
	
	public function onBlockPlace(BlockPlaceEvent $event) {
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$spawn = $level->getSpawnLocation();
		$distance = $spawn->distance($player);
		
		if($distance <= $this->cfg->get($level->getName())) {
			if(!$player->hasPermission("customradius.edit")) {
			$event->setCancelled(true);
			}
		}
	}
	
	public function onBlockBreak(BlockBreakEvent $event) {
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$spawn = $level->getSpawnLocation();
		$distance = $spawn->distance($player);
		
		if($distance <= $this->cfg->get($level->getName())) {
			if(!$player->hasPermission("customradius.edit")) {
			$event->setCancelled(true);
			}
		}
	}
	
	public function onDamage(EntityDamageEvent $event) {
		$player = $event->getEntity();
		$level = $player->getLevel();
		$spawn = $level->getSpawnLocation();
		$distance = $spawn->distance($player);
		
		if($player instanceof Player) {
		if($distance <= $this->cfg->get($level->getName())) {
			if(!$player->hasPermission("customradius.pvp")) {
			$event->setCancelled(true);
			}
		}
		}
	}
	

}

?>
