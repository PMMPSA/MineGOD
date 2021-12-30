<?php

namespace MuaRank;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
 
use _64FF00\PurePerms\PurePerms;

class Main extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
 		$this->getLogger()->info("§d§l====================\n§l§aＭＵＡ ＲＡＮＫ §aĐã Hoạt Động\n§d§l====================");
 	}
 	public function onCommand(CommandSender $s, Command $cmd, $label, array $args) {
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
 		$money = $this->eco->myMoney($s->getName());
 		$this->pp = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
 		if($cmd->getName() == "muarank") {
$s->sendMessage("§d[§l§eＭＵＡ §bＲＡＮＫ§r§d]§r§c §a/muarank help §eĐể Xem Cách §bＭＵＡ ＲＡＮＫ");
 			if(isset($args[0])) {
				switch(strtolower($args[0])) {
					case "help":
						$s->sendMessage("§d-=-=|§a §lCú Pháp ＭＵＡ ＲＡＮＫ§r§d |=-=-\n§e▶ §a/muarank god §c-§e Để Mua Rank §bGOD\n§d-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-");
 						break;
 						return true;
 					case "god":
						if($money >= 500000) {
							$this->eco->reduceMoney($s->getName(), 500000);
 							$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup ".$s->getName()." god");
 							$s->sendMessage("§d[§l§eＭＵＡ §bＲＡＮＫ§r§d]§r§a Mua Thành Công Rank §bPro Mem");
 						}else {
							$s->sendMessage("§d[§l§eＭＵＡ §bＲＡＮＫ§r§d]§r§c Bạn Không Đủ §eTiền §cĐể §bＭＵＡ ＲＡＮＫ");
 						}
 						break;
return true;
}
}
}
}
}