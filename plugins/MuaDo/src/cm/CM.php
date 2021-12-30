<?php

namespace cm;

use pocketmine\utils\TextFormat as __;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

class CM extends PluginBase {
	public $eco;
	
	public function onEnable(){
		$this->eco = EconomyAPI::getInstance();
		$this->getLogger()->info("Plugin Mua Đồ Của Con Đĩ AmGM");//lời nhắn khi bật plugin
	}
		public function onCommand(CommandSender $g, Command $c, $label, array $sl){//không đc edit dòng này
		//Các món hàng cần thêm
		//Xẻng cm✔
		//set đầu rồng vip✔
		//set huyền thoại
		//set pháp sư
		//set gaia
		//kiếm dark✔
		//kiếm light
		//cúp thần
		//cúp hsg✔
		//đề thi✔
		//bằng khen✔
        if ($this->getDescription()->getAuthors() !== ["AmGM"] || $this->getDescription()->getName() !== "Muado") {
            $this->getServer()->broadcastMessage("Tên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣Tên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\nTên vàng tên bạc của bố mày mà tại sao mày lại đổi địt cả lò nhà chúng mày\nôi dkm mày đổi lại ngay cho tao, ôi cái tên của tao thằng khốn nạn\n￣﹏￣\n");
            }
			 if($c->getName() == "muado"){//lệnh để người chơi sử dụng
			 $g->sendMessage("§e❤§a Sword Chrismas [swm]: §c90.000VNĐ");
			$g->sendMessage("§e❤§a Pickaxe Chrismas [pxm]: §c9.000VNĐ");	
			$g->sendMessage("§e❤§a Shovel Chrismas [svm]: §c90.000VNĐ");
			$g->sendMessage("§e❤§a Axe Chrismas [axm]: §c90.000VNĐ");
			$g->sendMessage("§e❤§a Set Dragon [setdrv]: §c800.000VNĐ");
			$g->sendMessage("§e❤§a Bằng Đại Học [bangdh]: §c1.200.040VNĐ");
			$g->sendMessage("§e❤§a Sword Dark [kd]: §c120.000VNĐ");
			$g->sendMessage("§e❤§a Pickaxe Học Sinh Giỏi [cuphsg]: §c150.000VNĐ\n§c•§e Dùng §c/muado mua [tên món]§6 để mua hàng");
			
			if(isset($sl[0])){
				switch(strtolower($sl[0])){
				case "mua":
				
			if(isset($sl[1])){
				switch(strtolower($sl[1])){
				case "swm"://món hangd
				if($this->eco->reduceMoney($g->getName(), 90000)){
				$this->eco->reduceMoney($g->getName(), 90000);
				$sw = Item::get(267,0,1);
				$sw->addEnchantment(Enchantment::getEnchantment(9)->setLevel(100));
				$sw->addEnchantment(Enchantment::getEnchantment(17)->setLevel(80));
				$sw->setCustomName("§r§l§e✦§f Sword Christmas§c (VIP)§e ✦");
				$sw->setLore(array("§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§r§l§e✔ Enchant ✔:\n§r§a➡§e Sharpness§b 100\n§a➡§e Unbreaking§b 80\n§7(§bItem§7 rất hiếm)\n§l§e✔ Nội dung ✔\n§r§a➡§e Item được tinh luyện rất lâu từ§b Satan (§cÔng già noel§b)\n§a➡§e Chỉ xuất hiện trong mùa §bgiáng sinh\n§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§a●§l§c Người tạo:§r§e AmGM§a (OWNER)\n§l§a✔§c Giá thị trường:§r§e 30.000VNĐ\n§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬"));
				$g->getInventory()->addItem($sw);
				$g->sendMessage("§e★§f Chúc bạn§e một mùa giáng sinh §aan lành\n§aGiỏ đồ: §eItem Sword Chrismas\n§bGiá: §d90.000VNĐ");
				}else{
				  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
				  }
				break;
				return true;
				case "pxm":
				if($this->eco->reduceMoney($g->getName(), 90000)){
				$this->eco->reduceMoney($g->getName(), 90000);
				$px = Item::get(257,0,1);
				$px->addEnchantment(Enchantment::getEnchantment(15)->setLevel(100));
				$px->addEnchantment(Enchantment::getEnchantment(17)->setLevel(80));
				$px->setCustomName("§r§l§e✦§f Pickaxe Christmas§c (VIP)§e ✦");
				$px->setLore(array("§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§r§l§e✔ Enchant ✔:\n§r§a➡§e Efficiency§b 100\n§a➡§e Unbreaking§b 80\n§7(§bItem§7 rất hiếm)\n§l§e✔ Nội dung ✔\n§r§a➡§e Item được tinh luyện rất lâu từ§b Satan (§cÔng già noel§b)\n§a➡§e Chỉ xuất hiện trong mùa §bgiáng sinh\n§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§a●§l§c Người tạo:§r§e AmGM§a (OWNER)\n§l§a✔§c Giá thị trường:§r§e 30.000VNĐ\n§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬"));
				$g->getInventory()->addItem($px);
				$g->sendMessage("§e★§f Chúc bạn§e một mùa giáng sinh §aan lành\n§aGiỏ đồ: §eItem Pickaxe Chrismas\n§bGiá: §d90.000VNĐ");
				}else{
								  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
				}
				break;
				return true;
				case "axm":
				if($this->eco->reduceMoney($g->getName(), 90000)){
				$this->eco->reduceMoney($g->getName(), 90000);
				$ax = Item::get(258,0,1);
				$ax->addEnchantment(Enchantment::getEnchantment(15)->setLevel(100));
				$ax->addEnchantment(Enchantment::getEnchantment(17)->setLevel(80));
				$ax->setCustomName("§r§l§e✦§f Axe Christmas§c (VIP)§e ✦");
				$ax->setLore(array("§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§r§l§e✔ Enchant ✔:\n§r§a➡§e Efficiency§b 100\n§a➡§e Unbreaking§b 80\n§7(§bItem§7 rất hiếm)\n§l§e✔ Nội dung ✔\n§r§a➡§e Item được tinh luyện rất lâu từ§b Satan (§cÔng già noel§b)\n§a➡§e Chỉ xuất hiện trong mùa §bgiáng sinh\n§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§a●§l§c Người tạo:§r§e AmGM§a (OWNER)\n§l§a✔§c Giá thị trường:§r§e 30.000VNĐ\n§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬"));
				$g->getInventory()->addItem($ax);
            				$g->sendMessage("§e★§f Chúc bạn§e một mùa giáng sinh §aan lành\n§aGiỏ đồ: §eItem Axe Chrismas\n§bGiá: §d90.000VNĐ");
			}else{
							  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
			}
			break;
			return true;
			case "bangdh":
			if($this->eco->reduceMoney($g->getName(), 1200040)){
				$this->eco->reduceMoney($g->getName(), 1200040);
			$bangdh = Item::get(339,0,1);
			$bangdh->setCustomName("§r§e§lBằng Đại Học 2018");
			$bangdh->setLore(array("                     §r§l§fsocιᴀʟʟιsт ʀᴇᴘuʙʟιc oғ vιᴇтɴᴀм                      
   \n                              §r§fᏒᎬᏟᏆᎾᏒ\n                              §r§fFRL University\n                    §l§cＴＨＥ ＤＥＧＲＥＥ ＯＦ ＢＡＣＨＥＬＯＲ\n               §r§aTrường Đại Học Quốc Tế DreamBlock MCPE 2018\n           §fUpon:§c ".$g->getName()."\n\n           §fDate of birth:§c */*/****\n\n           §fYear of graduation:§c 2018\n\n           §fDegree classification:§c Good\n\n           §fMode of study:§c Full-Time\n\n                                   §f§oFairyLand city */*/2018\n                                   \n§r§fReg.No: 263/FRCT                                   "));
            $g->getInventory()->addItem($bangdh);
             }else{
            				  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
             }
			break;
			return true;
             case "setdrv":
             if($this->eco->reduceMoney($g->getName(), 800000)){
             $this->eco->reduceMoney($g->getName(), 800000);
             $drv = Item::get(397,5,1);
             $drv->setCustomName("§r§e➤§a Đầu §drồng§c VIP§b 2018");
             $drv->setLore(array("§r§l§r§b▬▬▬▬▬§d▬▬▬▬▬§a▬▬▬▬▬§b▬▬▬▬▬§d▬▬▬▬▬§a▬▬▬▬▬§b▬▬▬▬▬\n§r§e✦§b Đầu rồng chỉ dành cho quý tộc\n§c☘§a Bảo vật ngàn năm của server\n§1⚠§6 Sức bảo vệ vô cùng mạnh mẽ\n§r§l§r§b▬▬▬▬▬§d▬▬▬▬▬§a▬▬▬▬▬§b▬▬▬▬▬§d▬▬▬▬▬§a▬▬▬▬▬§b▬▬▬▬▬\n\n§a●§c Vui lòng không làm mất\n\n§r§l§r§b▬▬▬▬▬§d▬▬▬▬▬§a▬▬▬▬▬§b▬▬▬▬▬§d▬▬▬▬▬§a▬▬▬▬▬§b▬▬▬▬▬"));
             $drv->addEnchantment(Enchantment::getEnchantment(0)->setLevel(100));
             $g->getInventory()->addItem($drv);
             $qu = Item::get(288,0,1);
             $qu->setCustomName("§r§e➤§a Vũ khí rồng§c VIP§b 2018");
             $qu->setLore(array("§r§1♦§e Vũ khí hiếm đi chung với §r§e➤§a Đầu §drồng§c VIP§b 2018\n§a☘§c Khả năng đánh xa rất cao"));
             $qu->addEnchantment(Enchantment::getEnchantment(12)->setLevel(100));
             $g->getInventory()->addItem($qu);
             $this->getServer()->broadcastTitle("§e".$g->getName()." \n§aVừa mua set§d Rồng\n§eTrị giá:§b 800.000VNĐ");
             $g->setMaxHealth(120);
             $g->setHealth(120);
            }else{
           				  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
           				  }
            break;
			return true;
            case "kd":
            if($this->eco->reduceMoney($g->getName(), 120000)){
            $kd = Item::get(276,0,1);
            $this->eco->reduceMoney($g->getName(), 120000);
            $kd->setCustomName("§r§a☘§d Kiếm §cDark§b ".$g->getName()." §a ☘");
            $kd->setLore(array("§r§l§d<====||§a•§d==||=>§e ＥＮＣＨＡＮＴ§d <=||§a•§d||====>\n§r§6♪§d Sharpness §b30\n§6♪§d Knockback §b10\n§6♪§d Unbreaking §b30\n§l§d<====||§a•§d==||=>§e ＩＮＦＯ§d <=||§a•§d||====>\n§r§6✔§a Chủ sở hữu: §b".$g->getName()."\n§6⚠§c Trị giá:§a 120.000VNĐ"));
            $kd->addEnchantment(Enchantment::getEnchantment(9)->setLevel(80));
            $kd->addEnchantment(Enchantment::getEnchantment(12)->setLevel(10));
            $kd->addEnchantment(Enchantment::getEnchantment(17)->setLevel(30));
            $g->getInventory()->addItem($kd);
            $g->sendMessage("§a♥§c Bạn đã mua§a item§1 Kiếm§c Dark§e thành công");
				}else{
								  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
				}
            break;
			return true;
				case "svm":
				if($this->eco->reduceMoney($g->getName(), 90000)){
				$this->eco->reduceMoney($g->getName(), 90000);
				$px = Item::get(256,0,1);
				$px->addEnchantment(Enchantment::getEnchantment(15)->setLevel(100));
				$px->addEnchantment(Enchantment::getEnchantment(17)->setLevel(80));
				$px->setCustomName("§r§l§e✦§f Shovel Christmas§c (VIP)§e ✦");
				$px->setLore(array("§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§r§l§e✔ Enchant ✔:\n§r§a➡§e Efficiency§b 100\n§a➡§e Unbreaking§b 80\n§7(§bItem§7 rất hiếm)\n§l§e✔ Nội dung ✔\n§r§a➡§e Item được tinh luyện rất lâu từ§b Satan (§cÔng già noel§b)\n§a➡§e Chỉ xuất hiện trong mùa §bgiáng sinh\n§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬\n§a●§l§c Người tạo:§r§e AmGM§a (OWNER)\n§l§a✔§c Giá thị trường:§r§e 30.000VNĐ\n§r§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬§6▬▬▬▬▬§e▬▬▬▬▬"));
				$g->getInventory()->addItem($px);
				$g->sendMessage("§e★§f Chúc bạn§e một mùa giáng sinh §aan lành\n§aGiỏ đồ: §eItem Shovel Chrismas\n§bGiá: §d90.000VNĐ");
				}else{
								  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
				}
				break;
				return true;
				case "cuphsg":
				if($this->eco->reduceMoney($g->getName(), 150000)){
				$this->eco->reduceMoney($g->getName(), 150000);
				$hsg = Item::get(285,0,1);
				$hsg->setCustomName("§c✉§e Cúp Học Sinh Giỏi §c✉");
				$hsg->addEnchantment(Enchantment::getEnchantment(15)->setLevel(90));
				$hsg->addEnchantment(Enchantment::getEnchantment(17)->setLevel(100));
				$hsg->setLore(array("§r§cDành cho học sinh giỏi:§6 ".$g->getName()." "));
				$g->getInventory()->addItem($hsg);
				$g->sendMessage("§c❤§a Bạn đã mua thành công cúp học sinh giỏi");
		}else{
						  $g->sendMessage("§c➡§a Bạn không có đủ§6 tiền§b để mua vật phẩm này");
		}
}
}
}
}
}
}
}
//this plugin code by amgm 100%, do not reup or share