<?php
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

class HelpSubCommand extends SubCommand
{
    public function canUse(CommandSender $sender) {
        return $sender->hasPermission("myplot.command.help");
    }

    /**
     * @return \MyPlot\Commands
     */
    private function getCommandHandler()
    {
        return $this->getPlugin()->getCommand($this->translateString("command.name"));
    }

    public function execute(CommandSender $sender, array $args) {
        if (count($args) === 0) {
            $pageNumber = 1;
        } elseif (is_numeric($args[0])) {
            $pageNumber = (int) array_shift($args);
            if ($pageNumber <= 0) {
                $pageNumber = 1;
            }
        } else {
            return false;
        }

        if ($sender instanceof ConsoleCommandSender) {
            $pageHeight = PHP_INT_MAX;
        } else {
            $pageHeight = 5;
        }

        $commands = [];
        foreach ($this->getCommandHandler()->getCommands() as $command) {
            if ($command->canUse($sender)) {
                $commands[$command->getName()] = $command;
            }
        }
        ksort($commands, SORT_NATURAL | SORT_FLAG_CASE);
        $commands = array_chunk($commands, $pageHeight);
        /** @var SubCommand[][] $commands */

							//////
            $sender->sendMessage("§r§c-=- §aSkyBlock - MineGOD §c-=-");
			$sender->sendMessage("§r§a/sb auto§7 - §fĐi Đến Một Hòn Đảo");
			$sender->sendMessage("§r§a/sb claim§7 - §fNhận Ngay Hòn Đảo Bạn Đang Đứng");
			$sender->sendMessage("§r§a/sb addhelper §e<Tên>§7 - §fThêm Người Vào Đảo Của Bạn");
			$sender->sendMessage("§r§a/sb removehelper §e<Tên>§7 - §fXóa Người Chơi Trong Đảo Của Bạn");
			$sender->sendMessage("§r§a/sb homes§7 - §fDanh Sách Đảo Của Bạn");
			$sender->sendMessage("§r§a/sb home §e<Số> §7 - §fDịch Chuyển Về Đảo Của Bạn");
			$sender->sendMessage("§r§a/sb info§7 - §fXem Thông Tin Hòn Đảo");
			$sender->sendMessage("§r§a/sb give §e<Tên Người Chơi> §7 - §fCho Người Khác Hòn Đảo Của Bạn");
			$sender->sendMessage("§r§a/sb warp §e<X;Y> §7 - §fDi Chuyển Đến Hòn Đảo Nào Đó");
			$sender->sendMessage("§r§c------------------------------------------");
        return true;
    }
}
