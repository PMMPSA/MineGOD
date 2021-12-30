<?php

namespace FireWings;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
	
	public $players = [];
	private $config = [];
	
	public function onEnable()
	{
		$df = $this->getDataFolder();
		@mkdir($df);
		if(!is_file($df . "config.yml")){
			$cfg = new Config($df . "config.yml", Config::YAML);
			$cfg->setAll([
				"wings-off" => "§6♦§bWingFire§6♦§c Bạn Đã Khóa §eCánh Lửa§c Thành Công",
				"wings-on" => "§6♦§bWingFire§6♦§a Bạn Đã Mở §eCánh Lửa§a Thành Công",
				"update-period" => 20
			]);
			$cfg->save();
		}
		$this->config = (new Config($df . "config.yml", Config::YAML))->getAll();
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new SendWingsTask($this), $this->config["update-period"]);
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $params)
	{
		if(!$sender instanceof Player){
			$sender->sendMessage("§f[§cVui Lòng Sử Dụng Lệnh Trong Trò Chơi§f]");
			return false;
		}
		$username = strtolower($sender->getName());
		if($command->getName() == "wingfire"){
			if(isset($this->players[$username])){
				unset($this->players[$username]);
				$sender->sendMessage($this->config["wings-off"]);
				return true;
			}else{
				$this->players[$username] = true;
				$sender->sendMessage($this->config["wings-on"]);
				return true;
			}
		}else{
			return false;
		}
	}
	
}
