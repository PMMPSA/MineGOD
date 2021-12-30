<?php
namespace HeoGM;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\level\Level;
use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TF::GREEN. "§aMua Item đã bật");
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		$cmd = $command->getName();
		switch(strtolower($cmd)){
			#TODO: cải thiện các lệnh
			case "muaitem":
			$sender->sendMessage(TF::RED . "Sự dụng: /muaitem [help|list]");
			if(isset($args[0])){
				switch(strtolower($args[0])){
					case "help":
					$sender->sendMessage(TF::YELLOW . "§b►§a Mua Item - Help");
					$sender->sendMessage(TF::AQUA . "• /muaitem item (item) để mua đồ, /muaitem list (trang) để xem các item trong shop.");
					$sender->sendMessage(TF::AQUA . "• /muaitem credits để xem thông tin về plugin MuaItem");
					return true;
					break;
					case "list":
					$sender->sendMessage(TF::YELLOW . "§b►§a Mua Item - Cúp (trang 1)");
					$sender->sendMessage(TF::BLUE . "§a-§f Cúp Thiên Đường <cupthienduong>");
					$sender->sendMessage(TF::BLUE . "§a-§f Cúp Thánh <cupthanh>");
					$sender->sendMessage(TF::BLUE . "§a-§f Cúp Thủy <cupthuy>");
					$sender->sendMessage(TF::BLUE . "§a-§f Cúp Titanium <cuptitanium>");
					$sender->sendMessage(TF::BLUE . "§a-§f Cúp Huyền Thoại <cuplegendary>");
					
					if(isset($args[1])){
						switch(strtolower($args[1])){
							case "2":
							$sender->sendMessage(TF::YELLOW . "§b►§a Mua Item - Ngọc (trang 2)");
							$sender->sendMessage(TF::AQUA . "§a-§f Hồng Ngọc <hongngoc>");
							$sender->sendMessage(TF::AQUA . "§a-§f Lam Ngọc <lamngoc>");
							$sender->sendMessage(TF::AQUA . "§a-§f Hỏa Ngọc <hoangoc>");
							$sender->sendMessage(TF::AQUA . "§a-§f Mảnh Ngôi Sao <star>");
							break;
							case "3":
							$sender->sendMessage(TF::YELLOW . "§b►§a Mua Item - Kiếm (trang 3)");
							$sender->sendMessage(TF::AQUA . "§a-§f Kiếm Hoàng Tộc  <royalsword>");
							$sender->sendMessage(TF::AQUA . "§a-§f Kiếm Thợ Săn <huntersword>");
							$sender->sendMessage(TF::AQUA . "§a-§f Kiếm Thạch Anh - Event <quartzsword>");
							$sender->sendMessage(TF::AQUA . "§a-§f Kiếm Huyền Thoại <legendarysword>");
							break;
							case "4":
							$sender->sendMessage(TF::YELLOW . "§b►§a Mua Item - Set (trang 4)");
							$sender->sendMessage(TF::AQUA . "§a-§f Set Thiên Đường  <setthienduong>");
							$sender->sendMessage(TF::AQUA . "§a-§f Set Thánh <setthanh>");
							$sender->sendMessage(TF::AQUA . "§a-§f Set Titanium <settitanium>");
							$sender->sendMessage(TF::AQUA . "§a-§f Set Huyền Thoại <sethuyenthoai>");
							break;
							case "5":
							$sender->sendMessage(TF::YELLOW . "§b►§a Mua Item - Rìu (trang 5)");
							$sender->sendMessage(TF::AQUA . "§a-§f Rìu Thiên Đường  <riuthienduong>");
							$sender->sendMessage(TF::AQUA . "§a-§f Rìu Thánh <riuthanh>");
							$sender->sendMessage(TF::AQUA . "§a-§f Rìu Titanium <riutitanium>");
							$sender->sendMessage(TF::AQUA . "§a-§f Rìu Huyền Thoại <riuhuyenthoai>");
							break;
						}
					}
					break;
					case "credits":
					$sender->sendMessage(TF::GREEN . " Phiên bản hiện tại: 4.0");
					return true;
					break;
					case "item":
					$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e /muaitem item <item> để mua đồ. Nhấn /muaitem list để xem danh sách item có thể mua.");
					if (isset($args[1])){
						switch(strtolower($args[1])){
							case "cupthienduong":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(378, 0, 10))){
									$i = Item::get(278, 0, 1);
									$i->setCustomName("§a§lCúp §bThiên§f Đường");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(9);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(20);
									$e2 = Enchantment::getEnchantment(18);
									$e2->setLevel(7);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(378, 0, 10));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Cúp Thiên Đường thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 10 Hồng Ngọc để mua vật phẩm này!");
								}
							}
							break;
							case "cupthuy":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(351, 12, 7))){
									$i = Item::get(278,0,1);
									$i->setCustomName("§a§lCúp §bThủy");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(16);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(30);
									$e2 = Enchantment::getEnchantment(18);
									$e2->setLevel(8);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(351, 12, 7));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Cúp Thủy thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 10 Lam Ngọc để mua vật phẩm này!");
								}
							}
							break;
							case "cupthanh":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(372, 0, 15))){
									$i = Item::get(278,0,1);
									$i->setCustomName("§a§lCúp §eThánh");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(20);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$e2 = Enchantment::getEnchantment(18);
									$e2->setLevel(10);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$inv->removeItem(Item::get(372, 0, 15));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Cúp Thánh thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 15 Hỏa Ngọc để mua vật phẩm này");
								}
							}
							break;
							case "cuptitanium":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(264, 0, 7))){
									$i = Item::get(278,0,1);
									$i->setCustomName("§a§lCúp §eTitanium");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(50);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$e2 = Enchantment::getEnchantment(18);
									$e2->setLevel(15);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(264, 0, 7));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Cúp Titanium thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 7 Diamonds để mua vật phẩm này");
								}
							}
							break;
							case "cuplegendary":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(399, 0, 4))){
									$i = Item::get(278,0,1);
									$i->setCustomName("§a§lCúp §eHuyền §6Thoại");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(100);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(100);
									$e2 = Enchantment::getEnchantment(18);
									$e2->setLevel(20);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(399, 0, 4));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Cúp Thần Thánh thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 4 Mảnh Ngôi Sao để mua vật phẩm này");
								}	
							}
							break;
							case "hongngoc":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(331,0,64))){
									$i = Item::get(378,0,1);
									$i->setCustomName("§c§lHồng Ngọc");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$inv->removeItem(Item::get(331,0,64));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Hồng Ngọc thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 64 Redstone để mua vật phẩm này");
								}
							}
							break;
							case "lamngoc":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(351,4,64))){
									$i = Item::get(351,12,1);
									$i->setCustomName("§b§lLam Ngọc");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$inv->removeItem(Item::get(351,4,64));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Lam Ngọc thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 64 Lapis để mua vật phẩm này");
								}
							}
							break;
							case "hoangoc":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(266,0,32))){
									$i = Item::get(372,0,1);
									$i->setCustomName("§c§lHỏa Ngọc");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$inv->removeItem(Item::get(266,0,32));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Hỏa Ngọc thành công!");
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 64 Vàng để mua vật phẩm này");
								}
							}
							break;
							case "star":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(388,0,6))){
									$i = Item::get(399,0,1);
									$i->setCustomName("§a§lMảnh Ngôi Sao");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$inv->removeItem(Item::get(388,0,6));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Mảnh Ngôi Sao thành công!");
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 6 Emerald để mua vật phẩm này");
								}
							}
							break;
							case "royalsword":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(372, 0, 7))){
									$i = Item::get(276,0,1);
									$i->setCustomName("§a§lKiếm§f Qúy§e Tộc");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(9);
									$e->setLevel(15);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(20);
									$e2 = Enchantment::getEnchantment(14);
									$e2->setLevel(5);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(372, 0, 7));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Kiếm Qúy Tộc thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 7 Hỏa Ngọc để mua vật phẩm này");
								}
							}
							break;
							case "huntersword":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(351,12,7))){
									$i = Item::get(276,0,1);
									$i->setCustomName("§a§lKiếm§c Thợ§b Săn");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(9);
									$e->setLevel(20);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(22);
									$e2 = Enchantment::getEnchantment(14);
									$e2->setLevel(6);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(351,12,7));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Kiếm Thợ Săn thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 7 Lam Ngọc để mua vật phẩm này");
								}
							}
							break;
							case "quartzsword":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(378,0,7))){
									$i = Item::get(276,0,1);
									$i->setCustomName("§a§lKiếm§f Thạch Anh");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(9);
									$e->setLevel(22);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(26);
									$e2 = Enchantment::getEnchantment(14);
									$e2->setLevel(8);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(378,0,7));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Kiếm Thạch Anh thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 7 Hồng Ngọc để mua vật phẩm này");
								}
							}
							break;
							case "legendarysword":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(399,0,4))){
									$i = Item::get(276,0,1);
									$i->setCustomName("§a§lKiếm§e Huyền§c Thoại");
									$i->setLore(array(TF::RED."§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(9);
									$e->setLevel(30);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$e2 = Enchantment::getEnchantment(14);
									$e2->setLevel(15);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$inv->removeItem(Item::get(399,0,4));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Kiếm Huyền Thoại thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 4 Mảnh Ngôi Sao để mua vật phẩm này");
								}
							}
							break;
							case "setthienduong":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(351,12,15))){
									$i = Item::get(310,0,1);
									$i->setCustomName("§a§lMũ§b Thiên§e Đường");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eMũ Thiên Đường§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(0);
									$e->setLevel(30);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$e2 = Enchantment::getEnchantment(5);
									$e2->setLevel(4);
									$i1 = Item::get(311,0,1);
									$i1->setCustomName("§a§lGiáp§b Thiên§e Đường");
									$i1->setLore(array(TF::RED."§b❅§a-----§c[§eGiáp Thiên Đường§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i2 = Item::get(312,0,1);
									$i2->setCustomName("§a§lQuần§b Thiên§e Đường");
									$i2->setLore(array(TF::RED."§b❅§a-----§c[§eQuần Thiên Đường§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i3 = Item::get(313,0,1);
									$i3->setCustomName("§a§lGiày§b Thiên§e Đường");
									$i3->setLore(array(TF::RED."§b❅§a-----§c[§eGiày Thiên Đường§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$i1->addEnchantment($e);
									$i1->addEnchantment($e1);
									$i1->addEnchantment($e2);
									$i2->addEnchantment($e);
									$i2->addEnchantment($e1);
									$i2->addEnchantment($e2);
									$i3->addEnchantment($e);
									$i3->addEnchantment($e1);
									$i3->addEnchantment($e2);
									$inv->removeItem(Item::get(351,12,15));
									$inv->addItem($i);
									$inv->addItem($i1);
									$inv->addItem($i2);
									$inv->addItem($i3);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Set Thiên Đường thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 15 Lam Ngọc để mua vật phẩm này");
								}
							}
							break;
							case "setthanh":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(372,0,10))){
									$i = Item::get(310,0,1);
									$i->setCustomName("§a§lMũ§b Thánh");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eMũ Thánh§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(0);
									$e->setLevel(20);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$e2 = Enchantment::getEnchantment(5);
									$e2->setLevel(3);
									$i1 = Item::get(311,0,1);
									$i1->setCustomName("§a§lGiáp§b Thánh");
									$i1->setLore(array(TF::RED."§b❅§a-----§c[§eGiáp Thánh§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i2 = Item::get(312,0,1);
									$i2->setCustomName("§a§lQuần§b Thánh");
									$i2->setLore(array(TF::RED."§b❅§a-----§c[§eQuần Thánh§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i3 = Item::get(313,0,1);
									$i3->setCustomName("§a§lGiày§b Titanium");
									$i3->setLore(array(TF::RED."§b❅§a-----§c[§eGiày Thánh§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$i1->addEnchantment($e);
									$i1->addEnchantment($e1);
									$i1->addEnchantment($e2);
									$i2->addEnchantment($e);
									$i2->addEnchantment($e1);
									$i2->addEnchantment($e2);
									$i3->addEnchantment($e);
									$i3->addEnchantment($e1);
									$i3->addEnchantment($e2);
									$inv->removeItem(Item::get(372,0,10));
									$inv->addItem($i);
									$inv->addItem($i1);
									$inv->addItem($i2);
									$inv->addItem($i3);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Set Thánh thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 10 Hỏa Ngọc để mua vật phẩm này");
								}
							}
							break;
							case "settitanium":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(264,0,12))){
									$i = Item::get(310,0,1);
									$i->setCustomName("§a§lMũ§b Titanium");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eMũ Titanium§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(0);
									$e->setLevel(20);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$e2 = Enchantment::getEnchantment(5);
									$e2->setLevel(3);
									$i1 = Item::get(311,0,1);
									$i1->setCustomName("§a§lGiáp§b Titanium");
									$i1->setLore(array(TF::RED."§b❅§a-----§c[§eGiáp Titanium§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i2 = Item::get(312,0,1);
									$i2->setCustomName("§a§lQuần§b Titanium");
									$i2->setLore(array(TF::RED."§b❅§a-----§c[§eQuần Titanium§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i3 = Item::get(313,0,1);
									$i3->setCustomName("§a§lGiày§b Titanium");
									$i3->setLore(array(TF::RED."§b❅§a-----§c[§eGiày Titanium§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$i1->addEnchantment($e);
									$i1->addEnchantment($e1);
									$i1->addEnchantment($e2);
									$i2->addEnchantment($e);
									$i2->addEnchantment($e1);
									$i2->addEnchantment($e2);
									$i3->addEnchantment($e);
									$i3->addEnchantment($e1);
									$i3->addEnchantment($e2);
									$inv->removeItem(Item::get(264,0,12));
									$inv->addItem($i);
									$inv->addItem($i1);
									$inv->addItem($i2);
									$inv->addItem($i3);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Set Titanium thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 12 Diamonds để mua vật phẩm này");
								}
							}
							break;
							case "sethuyenthoai":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(399,0,16))){
									$i = Item::get(310,0,1);
									$i->setCustomName("§a§lMũ§b Huyền§c Thoại");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eMũ Huyền Thoại§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(0);
									$e->setLevel(50);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(100);
									$e2 = Enchantment::getEnchantment(5);
									$e2->setLevel(8);
									$i1 = Item::get(311,0,1);
									$i1->setCustomName("§a§lGiáp§b Huyền§c Thoại");
									$i1->setLore(array(TF::RED."§b❅§a-----§c[§eGiáp Huyền Thoại§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i2 = Item::get(312,0,1);
									$i2->setCustomName("§a§lQuần§b Huyền§c Thoại");
									$i2->setLore(array(TF::RED."§b❅§a-----§c[§eQuần Huyền Thoại§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i3 = Item::get(313,0,1);
									$i3->setCustomName("§a§lGiày§b Huyền§c Thoại");
									$i3->setLore(array(TF::RED."§b❅§a-----§c[§eGiày Huyền Thoại§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$i->addEnchantment($e2);
									$i1->addEnchantment($e);
									$i1->addEnchantment($e1);
									$i1->addEnchantment($e2);
									$i2->addEnchantment($e);
									$i2->addEnchantment($e1);
									$i2->addEnchantment($e2);
									$i3->addEnchantment($e);
									$i3->addEnchantment($e1);
									$i3->addEnchantment($e2);
									$inv->removeItem(Item::get(399,0,16));
									$inv->addItem($i);
									$inv->addItem($i1);
									$inv->addItem($i2);
									$inv->addItem($i3);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Set Huyền Thoại thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 16 Mảnh Ngôi Sao để mua vật phẩm này");
								}
							}
							break;
							case "riuthienduong":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(372, 0, 3))){
									$i = Item::get(279,0,1);
									$i->setCustomName("§a§lRìu§b Thiên§c Đường");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eRìu Thiên Đường§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(4);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(20);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$inv->removeItem(Item::get(372, 0, 3));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Rìu Thiên Đường thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 3 Hỏa Ngọc Sao để mua vật phẩm này");
								}	
							}
							break;
							case "riuthanh":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(378, 0, 4))){
									$i = Item::get(279,0,1);
									$i->setCustomName("§a§lRìu§b Thánh");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eRìu Thánh§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(6);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(25);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$inv->removeItem(Item::get(378, 0, 4));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Rìu Thánh thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 4 Hồng Ngọc Sao để mua vật phẩm này");
								}	
							}
							break;
							case "riutitanium":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(264, 0, 15))){
									$i = Item::get(279,0,1);
									$i->setCustomName("§a§lRìu§b Titanium");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eRìu Titanium§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(8);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(50);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$inv->removeItem(Item::get(264, 0, 15));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Rìu Titanium thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 15 Diamonds Sao để mua vật phẩm này");
								}	
							}
							break;
							case "riuhuyenthoai":
							if ($sender instanceof Player){
								$inv = $sender->getInventory();
								if($inv->contains(Item::get(399, 0, 5))){
									$i = Item::get(279,0,1);
									$i->setCustomName("§a§lRìu§b Titanium");
									$i->setLore(array(TF::RED."§b❅§a-----§c[§eRìu Huyền Thoại§c]§a-----§b❅§r\n§c§lVật Phẩm Hiếm Không Bán Tại Shop!"));
									$e = Enchantment::getEnchantment(15);
									$e->setLevel(10);
									$e1 = Enchantment::getEnchantment(17);
									$e1->setLevel(100);
									$i->addEnchantment($e);
									$i->addEnchantment($e1);
									$inv->removeItem(Item::get(399, 0, 5));
									$inv->addItem($i);
									$sender->sendMessage(TF::GREEN . "§b[§aMuaItem§b]§e Mua Rìu Huyền Thoại thành công!");
									return true;
									break;
								}
								else{
									$sender->sendMessage(TF::RED . "§b[§aMuaItem§b]§e Bạn cần 5 Mảnh Ngôi Sao để mua vật phẩm này");
								}	
							}
							#Sẽ còn nhiều item khác cần phải làm
							#TODO: 2-1-2018
						}
					}
					break;
				}
			}
			break;
		}
    }
}