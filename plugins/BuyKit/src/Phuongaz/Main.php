<?php

namespace Phuongaz;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\CommandReader;
use pocketmine\command\CommandExecuter;
use pocketmine\command\ConsoleCommandSender;
class Main extends PluginBase implements Listener{
	public $tag = "§l§d[§eBUY§bKIT§d]§r ";
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		$this->getLogger()->info(TF::GREEN . "§d§l====================\n§l§eBUY§a KIT§6 BY§b Phuongaz \n§d§l====================");
	}
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		if ($cmd->getName() == "kit"){
		$sender->sendMessage($this->tag."§c /kit list để xem danh sách KIT");
		if(isset($args[0])){
				if(isset($args[0])){
				switch(strtolower($args[0])){
      case "list":
      $sender->sendMessage("§d-=-=|§a §lList KIT§d |=-=-");
      $sender->sendMessage("§d[1] §aKit §cDragon§6 100 000 XU");
      $sender->sendMessage("§d[2] §aKit §eThần Linh§6 200 000 XU");
      $sender->sendMessage("§d[3] §aKit §bThe King§6 300 000 XU");
      $sender->sendMessage("§d/kit [id] §a để mua");
      $sender->sendMessage("§d-=-=-=-=-=-=-=-=-=-=-=-=-");
      }
    }
  }
      if(isset($args[0])){
				if(isset($args[0])){
				switch(strtolower($args[0])){
				case "1":
				 $item1 = Item::get(310, 0, 1);
						 $item2 = Item::get(311, 0, 1);
						 $item3 = Item::get(312, 0, 1);
						 $item4 = Item::get(313, 0, 1);
						 $item5 = Item::get(276, 0, 1);
						 $item6 = Item::get(278, 0, 1);
						 $item7 = Item::get(278, 0, 1);
						 $item8 = Item::get(279, 0, 1);
						 $name1 = $item1->setCustomName("§r§b•=[§a Mũ §cDragon §b]=•");
						 $name2 = $item2->setCustomName("§r§b•=[§a Áo §cDragon §b]=•");
						 $name3 = $item3->setCustomName("§r§b•=[§a Quần §cDragon§b ]=•");
						 $name4 = $item4->setCustomName("§r§b•=[§a Giày §cDragon§b ]=•");
						 $name5 = $item5->setCustomName("§r§b•=[§a Kiếm §cDragon§b ]=•");
						 $name6 = $item6->setCustomName("§r§b•=[§a Cúp §cDragon§b ]=•");
 $money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender);
						  if ($money < 100000){
							  $sender->sendMessage(TF::RED . "Không đủ tiền");
						  }
						  else{
						   $item1->addEnchantment(Enchantment::getEnchantment(0)->setLevel(10));
						    $item1->addEnchantment(Enchantment::getEnchantment(2)->setLevel(10));
							 $item1->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item1->addEnchantment(Enchantment::getEnchantment(17)->setLevel(50));
							 $item2->addEnchantment(Enchantment::getEnchantment(0)->setLevel(10));
							  $item1->addEnchantment(Enchantment::getEnchantment(2)->setLevel(10));
							 $item2->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item2->addEnchantment(Enchantment::getEnchantment(17)->setLevel(50));
							 $item3->addEnchantment(Enchantment::getEnchantment(0)->setLevel(10));
							 $item3->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item3->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item4->addEnchantment(Enchantment::getEnchantment(0)->setLevel(10));
							 $item4->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item4->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item5->addEnchantment(Enchantment::getEnchantment(9)->setLevel(10));
							 $item5->addEnchantment(Enchantment::getEnchantment(12)->setLevel(2));
							 $item5->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item6->addEnchantment(Enchantment::getEnchantment(15)->setLevel(9));
							 $item6->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							   $sender->getInventory()->addItem($item1);
							 $sender->getInventory()->addItem($item2);
							 $sender->getInventory()->addItem($item3);
							 $sender->getInventory()->addItem($item4);
							 $sender->getInventory()->addItem($item5);
							 //$sender->getInventory()->addItem($item6);
							 $item1->setCustomName($name1);
							 $item2->setCustomName($name2);
							 $item3->setCustomName($name3);
							 $item4->setCustomName($name4);
							 $item5->setCustomName($name5);
							 $item6->setCustomName($name6);
						  $sender->sendMessage($this->tag. "§a Mua Thành Công KIT");
						  
						  
							  $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->reduceMoney($sender->getName(), 100000);
							  }
 return true;
					  break;
					  case "2":
					   $item1 = Item::get(310, 0, 1);
						 $item2 = Item::get(311, 0, 1);
						 $item3 = Item::get(312, 0, 1);
						 $item4 = Item::get(313, 0, 1);
						 $item5 = Item::get(276, 0, 1);
						 $item6 = Item::get(278, 0, 1);
						 $item7 = Item::get(278, 0, 1);
						 $item8 = Item::get(279, 0, 1);
						 $name1 = $item1->setCustomName("§r§b•=[§a Mũ §eThần Linh §b]=•");
						 $name2 = $item2->setCustomName("§r§b•=[§a Áo §eThần Linh §b]=•");
						 $name3 = $item3->setCustomName("§r§b•=[§a Quần §eThần Linh§b ]=•");
						 $name4 = $item4->setCustomName("§r§b•=[§a Giày §eThần Linh§b ]=•");
						 $name5 = $item5->setCustomName("§r§b•=[§a Kiếm §eThần Linh§b ]=•");
						 $name6 = $item6->setCustomName("§r§b•=[§a Cúp §cDragon§b ]=•");
 $money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender);
						  if ($money < 200000){
							  $sender->sendMessage(TF::RED . "Không đủ tiền");
						  }
						  else{
						   $item1->addEnchantment(Enchantment::getEnchantment(0)->setLevel(20));
						    $item1->addEnchantment(Enchantment::getEnchantment(2)->setLevel(20));
							 $item1->addEnchantment(Enchantment::getEnchantment(5)->setLevel(5));
							 $item1->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item2->addEnchantment(Enchantment::getEnchantment(0)->setLevel(50));
							  $item1->addEnchantment(Enchantment::getEnchantment(2)->setLevel(20));
							 $item2->addEnchantment(Enchantment::getEnchantment(5)->setLevel(10));
							 $item2->addEnchantment(Enchantment::getEnchantment(17)->setLevel(50));
							 $item3->addEnchantment(Enchantment::getEnchantment(0)->setLevel(20));
	$item3->addEnchantment(Enchantment::getEnchantment(2)->setLevel(10));
							 $item3->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item3->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item4->addEnchantment(Enchantment::getEnchantment(0)->setLevel(10));
							 $item4->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item4->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item5->addEnchantment(Enchantment::getEnchantment(9)->setLevel(20));
							 $item5->addEnchantment(Enchantment::getEnchantment(12)->setLevel(4));
							 $item5->addEnchantment(Enchantment::getEnchantment(17)->setLevel(999999998));
							 $item5->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item6->addEnchantment(Enchantment::getEnchantment(15)->setLevel(9));
							 $item6->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							   $sender->getInventory()->addItem($item1);
							 $sender->getInventory()->addItem($item2);
							 $sender->getInventory()->addItem($item3);
							 $sender->getInventory()->addItem($item4);
							 $sender->getInventory()->addItem($item5);
							 //$sender->getInventory()->addItem($item6);
							 $item1->setCustomName($name1);
							 $item2->setCustomName($name2);
							 $item3->setCustomName($name3);
							 $item4->setCustomName($name4);
							 $item5->setCustomName($name5);
							 $item6->setCustomName($name6);
						  $sender->sendMessage($this->tag. "§a Mua Thành Công KIT");
						  
						  
							  $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->reduceMoney($sender->getName(), 100000);
							  }
						 return true;
					  break;
					  case "3":
					   $item1 = Item::get(310, 0, 1);
						 $item2 = Item::get(311, 0, 1);
						 $item3 = Item::get(312, 0, 1);
						 $item4 = Item::get(313, 0, 1);
						 $item5 = Item::get(276, 0, 1);
						 $item6 = Item::get(278, 0, 1);
						 $item7 = Item::get(278, 0, 1);
						 $item8 = Item::get(279, 0, 1);
						 $name1 = $item1->setCustomName("§l§b•=[§a Mũ §bThe KING §b]=•");
						 $name2 = $item2->setCustomName("§l§b•=[§a Áo §bThe KING §b]=•");
						 $name3 = $item3->setCustomName("§l§b•=[§a Quần §bThe KING§b ]=•");
						 $name4 = $item4->setCustomName("§l§b•=[§a Giày §bThe KING§b ]=•");
						 $name5 = $item5->setCustomName("§l§b•=[§a Kiếm §bThe KING§b ]=•");
						 $name6 = $item6->setCustomName("§l§b•=[§a Cúp §cDragon§b ]=•");
 $money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->myMoney($sender);
						  if ($money < 300000){
							  $sender->sendMessage(TF::RED . "Không đủ tiền");
						  }
						  else{
						   $item1->addEnchantment(Enchantment::getEnchantment(0)->setLevel(50));
						    $item1->addEnchantment(Enchantment::getEnchantment(2)->setLevel(50));
							 $item1->addEnchantment(Enchantment::getEnchantment(5)->setLevel(10));
							 $item1->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item2->addEnchantment(Enchantment::getEnchantment(0)->setLevel(50));
							  $item1->addEnchantment(Enchantment::getEnchantment(2)->setLevel(30));
							 $item2->addEnchantment(Enchantment::getEnchantment(5)->setLevel(10));
							 $item2->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item3->addEnchantment(Enchantment::getEnchantment(0)->setLevel(100));
	$item3->addEnchantment(Enchantment::getEnchantment(2)->setLevel(10));
							 $item3->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item3->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item4->addEnchantment(Enchantment::getEnchantment(0)->setLevel(100));
							 $item4->addEnchantment(Enchantment::getEnchantment(5)->setLevel(2));
							 $item4->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item5->addEnchantment(Enchantment::getEnchantment(9)->setLevel(50));
							 $item5->addEnchantment(Enchantment::getEnchantment(12)->setLevel(5));
							 $item5->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							 $item6->addEnchantment(Enchantment::getEnchantment(15)->setLevel(9));
							 $item6->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
							   $sender->getInventory()->addItem($item1);
							 $sender->getInventory()->addItem($item2);
							 $sender->getInventory()->addItem($item3);
							 $sender->getInventory()->addItem($item4);
							 $sender->getInventory()->addItem($item5);
							 //$sender->getInventory()->addItem($item6);
							 $item1->setCustomName($name1);
							 $item2->setCustomName($name2);
							 $item3->setCustomName($name3);
							 $item4->setCustomName($name4);
							 $item5->setCustomName($name5);
							 $item6->setCustomName($name6);
						  $sender->sendMessage($this->tag. "§a Mua Thành Công KIT");
						  
						  
							  $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->reduceMoney($sender->getName(), 300000);
							  }
							  return true;
						}
				}
		}
}
}
}