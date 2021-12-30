<?php

namespace RandomOre;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\block\Stone;
use pocketmine\block\Fence;
use pocketmine\block\Water;
use pocketmine\block\IronOre;
use pocketmine\block\DiamondOre;
use pocketmine\block\EmeraldOre;
use pocketmine\block\GoldOre;
use pocketmine\block\CoalOre;
use pocketmine\block\LapisOre;
use pocketmine\block\RedstoneOre;
use pocketmine\block\Quartz;

class Main extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getLogger()->info("§l§a>Plugins RanDomOre Đã Được Bật!");
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }
    //cái Lozz : )) Chỉnh Đi mày

        public function onBlockSet(BlockUpdateEvent $event){
        $block = $event->getBlock();
        $water = false;
        $fence = false;
        for ($i = 2; $i <= 5; $i++) {
            $nearBlock = $block->getSide($i);
            if ($nearBlock instanceof Water) {
                $water = true;
            } else if ($nearBlock instanceof Fence) {
                $fence = true;
            }
            if ($water && $fence) {
                $id = mt_rand(1, 20);
                switch ($id) {
                    case 2;
                        $newBlock = new Stone();
                        break;
					case 3;
                        $newBlock = new IronOre();
                        break;
                    case 4;
                        $newBlock = new GoldOre();
                        break;
                    case 5;
                        $newBlock = new EmeraldOre();
                        break;
                    case 6;
                        $newBlock = new CoalOre();
                        break;
                    case 7;
                        $newBlock = new RedstoneOre();
                        break;
                    case 8;
                        $newBlock = new DiamondOre();
                        break;
					case 9;
                        $newBlock = new LapisOre();
                        break;
                    case 10;
                        $newBlock = new Quartz();
                        break;
                    default:
                        $newBlock = new Stone();
                }
                $block->getLevel()->setBlock($block, $newBlock, true, false);
                return;
            }
        }
    }
}
//1 RandomOre Là Gì?... Giúp Người Chơi Fram Các Block Khác Nhau.... Thích Hợp Làm SkyBlock... Thank You Download!!!
//2 Bạn Có Thể Chỉnh Sửa Thời Gian Block Ra Hoặc Đổi Block Khác!!!
//3 Bạn Có Thể Chỉnh Gì Tùy Bạn Ngay Cả AuThor Và Tên Plugins Thành RamdomConCac : )) 
