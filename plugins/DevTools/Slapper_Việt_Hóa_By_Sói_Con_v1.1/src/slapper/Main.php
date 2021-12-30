<?php

namespace slapper;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntitySpawnEvent;
use pocketmine\event\Listener;
use pocketmine\Item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use slapper\entities\other\SlapperBoat;
use slapper\entities\other\SlapperFallingSand;
use slapper\entities\other\SlapperMinecart;
use slapper\entities\other\SlapperPrimedTNT;
use slapper\entities\SlapperBat;
use slapper\entities\SlapperBlaze;
use slapper\entities\SlapperCaveSpider;
use slapper\entities\SlapperChicken;
use slapper\entities\SlapperCow;
use slapper\entities\SlapperCreeper;
use slapper\entities\SlapperDonkey;
use slapper\entities\SlapperEnderman;
use slapper\entities\SlapperEntity;
use slapper\entities\SlapperGhast;
use slapper\entities\SlapperHorse;
use slapper\entities\SlapperHuman;
use slapper\entities\SlapperHusk;
use slapper\entities\SlapperIronGolem;
use slapper\entities\SlapperLavaSlime;
use slapper\entities\SlapperMule;
use slapper\entities\SlapperMushroomCow;
use slapper\entities\SlapperOcelot;
use slapper\entities\SlapperPig;
use slapper\entities\SlapperPigZombie;
use slapper\entities\SlapperRabbit;
use slapper\entities\SlapperSheep;
use slapper\entities\SlapperSilverfish;
use slapper\entities\SlapperSkeleton;
use slapper\entities\SlapperSkeletonHorse;
use slapper\entities\SlapperSlime;
use slapper\entities\SlapperSnowman;
use slapper\entities\SlapperSpider;
use slapper\entities\SlapperSquid;
use slapper\entities\SlapperStray;
use slapper\entities\SlapperVillager;
use slapper\entities\SlapperWitch;
use slapper\entities\SlapperWitherSkeleton;
use slapper\entities\SlapperWolf;
use slapper\entities\SlapperZombie;
use slapper\entities\SlapperZombieHorse;
use slapper\entities\SlapperZombieVillager;
use slapper\events\SlapperCreationEvent;
use slapper\events\SlapperDeletionEvent;
use slapper\events\SlapperHitEvent;


class Main extends PluginBase implements Listener {

	const ENTITY_TYPES = [
		"Chicken", "Pig", "Sheep", "Cow",
		"MushroomCow", "Wolf", "Enderman", "Spider",
		"Skeleton", "PigZombie", "Creeper", "Slime",
		"Silverfish", "Villager", "Zombie", "Human",
		"Bat", "CaveSpider", "LavaSlime", "Ghast",
		"Ocelot", "Blaze", "ZombieVillager", "Snowman",
		"Minecart", "FallingSand", "Boat", "PrimedTNT",
		"Horse", "Donkey", "Mule", "SkeletonHorse",
		"ZombieHorse", "Witch", "Rabbit", "Stray",
		"Husk", "WitherSkeleton", "IronGolem", "Snowman",
		"MagmaCube", "Squid"
	];

	const ENTITY_ALIASES = [
		"ZombiePigman" => "PigZombie",
		"Mooshroom" => "MushroomCow",
		"Player" => "Human",
		"VillagerZombie" => "ZombieVillager",
		"SnowGolem" => "Snowman",
		"FallingBlock" => "FallingSand",
		"FakeBlock" => "FallingSand",
		"VillagerGolem" => "IronGolem",
	];

	public $hitSessions = [];
	public $idSessions = [];
	public $prefix = (TextFormat::LIGHT_PURPLE . "♦" . TextFormat::AQUA . "Slapper Việt Hóa" . TextFormat::LIGHT_PURPLE . "♦");
	public $noperm = (TextFormat::LIGHT_PURPLE . "♦" . TextFormat::AQUA . "Slapper Việt Hóa" . TextFormat::LIGHT_PURPLE . " ♦");
	public $helpHeader =
		(
			TextFormat::AQUA . "---------- " .
			TextFormat::LIGHT_PURPLE . "♦" . TextFormat::YELLOW . "Slapper Trợ Giúp" . TextFormat::LIGHT_PURPLE . "♦" .
			TextFormat::AQUA . "----------"
		);
	public $mainArgs = [
		"§e♦ §dSử dụng §c/slapper help§d nếu không biết lệnh §e♦",
		"§e♦ §dSử dụng §c/slapper spawn <type> [name]§d để tạo ra slapper §e♦",
		"§e♦ §dSử dụng §c/slapper edit [id] [args...]§d để chỉnh sửa slapper §e♦",
		"§e♦ §dSử dụng §c/slapper id§d để xem id của slapper §e♦",
		"§e♦ §dSử dụng §c/slapper remove [id]§d để xóa slapper §e♦",
		"§e♦ §dSử dụng §c/slapper version§d để xem version slapper §e♦",
		"§e♦ §dSử dụng §c/slapper cancel§d để từ chối 1 lệnh slapper §e♦",
	];
	public $editArgs = [
		"§e♦ §aNón → §dSử dụng §c/slapper edit <eid> helmet <id>§d để chỉnh sửa nón cho slapper §e♦",
		"§e♦ §aGiáp → §dSử dụng §c/slapper edit <eid> chestplate <id>§d để chỉnh sửa giáp cho slapper §e♦",
		"§e♦ §aQuần → §dSử dụng §c/slapper edit <eid> leggings <id>§d để chỉnh sửa quần cho slapper §e♦",
		"§e♦ §aGiày → §dSử dụng §c/slapper edit <eid> boots <id>§d để chỉnh sửa giày cho slapper §e♦",
		"§e♦ §aSkin → §dSử dụng §c/slapper edit <eid> skin§d để chỉnh sửa skin cho slapper §e♦",
		"§e♦ §aTên → §dSử dụng §c/slapper edit <eid> name <name>§d để chỉnh sửa tên cho slapper §e♦",
		"§e♦ §aTên hiển thị → §dSử dụng §c/slapper edit <eid> namevisibility <never/hover/always>§d để chỉnh sửa tên hiển thị cho slapper §e♦",
		"§e♦ §aThêm Lệnh → §dSử dụng §c/slapper edit <eid> addcommand <command>§d để thêm lệnh vào slapper §e♦",
		"§e♦ §aXóa Lệnh → §dSử dụng §c/slapper edit <eid> delcommand <command>§d để xóa lệnh cho slapper §e♦",
		"§e♦ §aDanh sách lệnh → §dSử dụng §c/slapper edit <eid> listcommands§d để xem lệnh đã thêm vào slapper §e♦",
		"§e♦ §aBlock ° → §dSử dụng §c/slapper edit <eid> block <id[:meta]>§d để chỉnh sửa block đi xuống/đi lên §e♦",
		"§e♦ §aSlapper Size → §dSử dụng §c/slapper edit <eid> scale <size>§d để chỉnh sửa size slapper §e♦",
		"§e♦ §aTeleport Here → §dSử dụng §c/slapper edit <eid> tphere§d để teleport slapper đến người chơi §e♦",
		"§e♦ §aTeleport To → §dSử dụng §c/slapper edit <eid> tpto§d để teleport đến slapper §e♦",
		"§e♦ §aMenu Tên → §dSử dụng §c/slapper edit <eid> menuname <name/remove>§d để chỉnh sửa tên slapper trên menu online §e♦"
	];

	public function onEnable() {
		Entity::registerEntity(SlapperCreeper::class, true);
		Entity::registerEntity(SlapperBat::class, true);
		Entity::registerEntity(SlapperSheep::class, true);
		Entity::registerEntity(SlapperPigZombie::class, true);
		Entity::registerEntity(SlapperGhast::class, true);
		Entity::registerEntity(SlapperBlaze::class, true);
		Entity::registerEntity(SlapperIronGolem::class, true);
		Entity::registerEntity(SlapperSnowman::class, true);
		Entity::registerEntity(SlapperOcelot::class, true);
		Entity::registerEntity(SlapperZombieVillager::class, true);
		Entity::registerEntity(SlapperHuman::class, true);
		Entity::registerEntity(SlapperVillager::class, true);
		Entity::registerEntity(SlapperZombie::class, true);
		Entity::registerEntity(SlapperSquid::class, true);
		Entity::registerEntity(SlapperCow::class, true);
		Entity::registerEntity(SlapperSpider::class, true);
		Entity::registerEntity(SlapperPig::class, true);
		Entity::registerEntity(SlapperMushroomCow::class, true);
		Entity::registerEntity(SlapperWolf::class, true);
		Entity::registerEntity(SlapperLavaSlime::class, true);
		Entity::registerEntity(SlapperSilverfish::class, true);
		Entity::registerEntity(SlapperSkeleton::class, true);
		Entity::registerEntity(SlapperSlime::class, true);
		Entity::registerEntity(SlapperChicken::class, true);
		Entity::registerEntity(SlapperEnderman::class, true);
		Entity::registerEntity(SlapperCaveSpider::class, true);
		Entity::registerEntity(SlapperBoat::class, true);
		Entity::registerEntity(SlapperMinecart::class, true);
		Entity::registerEntity(SlapperPrimedTNT::class, true);
		Entity::registerEntity(SlapperHorse::class, true);
		Entity::registerEntity(SlapperDonkey::class, true);
		Entity::registerEntity(SlapperMule::class, true);
		Entity::registerEntity(SlapperSkeletonHorse::class, true);
		Entity::registerEntity(SlapperZombieHorse::class, true);
		Entity::registerEntity(SlapperRabbit::class, true);
		Entity::registerEntity(SlapperWitch::class, true);
		Entity::registerEntity(SlapperStray::class, true);
		Entity::registerEntity(SlapperHusk::class, true);
		Entity::registerEntity(SlapperWitherSkeleton::class, true);
		Entity::registerEntity(SlapperFallingSand::class, true);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		switch (strtolower($command->getName())) {
			case 'nothing':
				return true;
				break;
			case 'rca':
				if(count($args) < 2) {
					$sender->sendMessage($this->prefix . " §c• §bHãy đặt tên cho slapper hoặc command !");
					return true;
				}
				$player = $this->getServer()->getPlayer(array_shift($args));
				if($player instanceof Player) {
					$this->getServer()->dispatchCommand($player, trim(implode(" ", $args)));
					return true;
				} else {
					$sender->sendMessage($this->prefix . " §c• §bKhông thể tìm thấy người chơi !");
					return true;
				}
				break;
			case "slapper":
				if($sender instanceof Player) {
					if(!(isset($args[0]))) {
						if($sender->hasPermission("slapper.command") || $sender->hasPermission("slapper")) {
							$sender->sendMessage($this->prefix . " §c• §bSử dụng §c/slapper help§b nếu bạn không biết lệnh");
							return true;
						} else {
							$sender->sendMessage($this->noperm);
							return true;
						}
					}
					$arg = array_shift($args);
					switch ($arg) {
						case "id":
							if($sender->hasPermission("slapper.id") || $sender->hasPermission("slapper")) {
								$this->idSessions[$sender->getName()] = true;
								$sender->sendMessage($this->prefix . " §c• §bTap vào slapper để xem id !");
								return true;
							} else {
								$sender->sendMessage($this->noperm);
								return true;
							}
							break;
						case "version":
							if($sender->hasPermission("slapper.version") || $sender->hasPermission("slapper")) {
								$desc = $this->getDescription();
								$sender->sendMessage($this->prefix . TextFormat::LIGHT_PURPLE . $desc->getName() . " " . $desc->getVersion() . " " . TextFormat::AQUA . "" . TextFormat::GOLD . "");
								return true;
							} else {
								$sender->sendMessage($this->noperm);
								return true;
							}
							break;
						case "cancel":
						case "stopremove":
						case "stopid":
							unset($this->hitSessions[$sender->getName()]);
							unset($this->idSessions[$sender->getName()]);
							$sender->sendMessage($this->prefix . " §c• §bTừ chối lệnh !");
							return true;
							break;
						case "remove":
							if($sender->hasPermission("slapper.remove") || $sender->hasPermission("slapper")) {
								if(isset($args[0])) {
									$entity = $sender->getLevel()->getEntity($args[0]);
									if($entity !== null) {
										if($entity instanceof SlapperEntity || $entity instanceof SlapperHuman) {
											$this->getServer()->getPluginManager()->callEvent(new SlapperDeletionEvent($entity));
											$entity->close();
											$sender->sendMessage($this->prefix . " §c• §bEntity đã bị xóa bỏ !");
										} else {
											$sender->sendMessage($this->prefix . " §c• Entity này không thể xử lí bởi slapper !");
										}
									} else {
										$sender->sendMessage($this->prefix . " §c• §bEntity này không tồn tại !");
									}
									return true;
								}
								$this->hitSessions[$sender->getName()] = true;
								$sender->sendMessage($this->prefix . " §c• §bTap vào slapper để xóa bỏ entity !");
							} else {
								$sender->sendMessage($this->noperm);
								return true;
							}
							return true;
							break;
						case "edit":
							if($sender->hasPermission("slapper.edit") || $sender->hasPermission("slapper")) {
								if(isset($args[0])) {
									$level = $sender->getLevel();
									$entity = $level->getEntity($args[0]);
									if($entity !== null) {
										if($entity instanceof SlapperEntity || $entity instanceof SlapperHuman) {
											if(isset($args[1])) {
												switch ($args[1]) {
													case "helm":
													case "helmet":
													case "head":
													case "hat":
													case "cap":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setHelmet(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " §c• §bĐã update mũ cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bHãy nhập id item vào !");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bOops ! Entity này không thể mặc giáp");
														}
														return true;
													case "chest":
													case "shirt":
													case "chestplate":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setChestplate(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " §c• §bĐã update giáp cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bHãy nhập id item vào !");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bOops ! Entity này không thể mặc giáp");
														}
														return true;
													case "pants":
													case "legs":
													case "leggings":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setLeggings(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " §c• §bĐã update quần cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bHãy nhập id item vào !");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bOops ! Entity này không thể mặc giáp");
														}
														return true;
													case "feet":
													case "boots":
													case "shoes":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setBoots(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " §c• §bĐã update giày cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bHãy nhập id item vào !");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bOops ! Entity này không thể mặc giáp");
														}
														return true;
													case "hand":
													case "item":
													case "holding":
													case "arm":
													case "held":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setItemInHand(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " §c• §bĐã update item cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bHãy nhập id item vào !");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bOops ! Entity này không thể mặc giáp");
														}
														return true;
													case "setskin":
													case "changeskin":
													case "editskin";
													case "skin":
														if($entity instanceof SlapperHuman) {
															$entity->setSkin($sender->getSkinData(), $sender->getSkinId());
															$entity->sendData($entity->getViewers());
															$sender->sendMessage($this->prefix . " §c• §bĐã update skin cho slapper");
														} else {
															$sender->sendMessage($this->prefix . " §c• §bRất tiếc ! Entity này không thể thay skin");
														}
														return true;
													case "name":
													case "customname":
														if(isset($args[2])) {
															array_shift($args);
															array_shift($args);
															$entity->setNameTag(trim(implode(" ", $args)));
															$entity->sendData($entity->getViewers());
															$sender->sendMessage($this->prefix . " §c• §bĐã update tên cho slapper");
														} else {
															$sender->sendMessage($this->prefix . " §c• §bHãy nhập tên slapper vào");
														}
														return true;
													case "listname":
													case "nameonlist":
													case "menuname":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$type = 0;
																array_shift($args);
																array_shift($args);
																$input = trim(implode(" ", $args));
																switch (strtolower($input)) {
																	case "remove":
																	case "":
																	case "disable":
																	case "off":
																	case "hide":
																		$type = 1;
																}
																if($type === 0) {
																	$entity->namedtag->MenuName = new StringTag("MenuName", $input);
																} else {
																	$entity->namedtag->MenuName = new StringTag("MenuName", "");
																}
																$entity->respawnToAll();
																$sender->sendMessage($this->prefix . " §c• §bMenu tên update");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bHãy nhập tên cho menu !");
																return true;
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bEntity này không thể có menu tên !");
														}
														return true;
														break;
													case "namevisibility":
													case "namevisible":
													case "customnamevisible":
													case "tagvisible":
													case "name_visible":
														if(isset($args[2])) {
															switch (strtolower($args[2])) {
																case "a":
																case "always":
																case "1":
																	$entity->setNameTagVisible(true);
																	$entity->setNameTagAlwaysVisible(true);
																	$entity->sendData($entity->getViewers());
																	$sender->sendMessage($this->prefix . " §c• §bTên hiển thị đã update !");
																	return true;
																	break;
																case "h":
																case "hover":
																case "lookingat":
																case "onhover":
																	$entity->setNameTagVisible(true);
																	$entity->setNameTagAlwaysVisible(false);
																	$entity->sendData($entity->getViewers());
																	$sender->sendMessage($this->prefix . " §c• §bTên hiển thị đã update !");
																	return true;
																	break;
																case "n":
																case "never":
																case "no":
																case "0":
																	$entity->setNameTagVisible(false);
																	$entity->setNameTagAlwaysVisible(false);
																	$entity->sendData($entity->getViewers());
																	$sender->sendMessage($this->prefix . " §c• §bTên hiển thị đã update !");
																	return true;
																	break;
																default:
																	$sender->sendMessage($this->prefix . " §c• §bHãy điền các loại này \"always\", \"hover\", §bhoặc \"never\".");
																	return true;
																	break;
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bHãy điền các loại này \"always\", \"hover\", §bhoặc \"never\".");
														}
														return true;
													case "addc":
													case "addcmd":
													case "addcommand":
														if(isset($args[2])) {
															array_shift($args);
															array_shift($args);
															$input = trim(implode(" ", $args));
															if(isset($entity->namedtag->Commands[$input])) {
																$sender->sendMessage($this->prefix . " §c• §bCommand này đã được add vào slapper !");
																return true;
															}
															$entity->namedtag->Commands[$input] = new StringTag($input, $input);
															$sender->sendMessage($this->prefix . " §c• §bĐã add thành công command !");
														} else {
															$sender->sendMessage($this->prefix . " §c• §bHãy nhập command vào !");
														}
														return true;
													case "delc":
													case "delcmd":
													case "delcommand":
													case "removecommand":
														if(isset($args[2])) {
															array_shift($args);
															array_shift($args);
															$input = trim(implode(" ", $args));
															unset($entity->namedtag->Commands[$input]);
															$sender->sendMessage($this->prefix . " §c• §bĐã xóa thành công command !");
														} else {
															$sender->sendMessage($this->prefix . " §c• §bHãy nhập command vào !");
														}
														return true;
													case "listcommands":
													case "listcmds":
													case "listcs":
														if(!(empty($entity->namedtag->Commands))) {
															$id = 0;
															foreach ($entity->namedtag->Commands as $cmd) {
																$id++;
																$sender->sendMessage(TextFormat::GREEN . "[" . TextFormat::YELLOW . "S" . TextFormat::GREEN . "] " . TextFormat::YELLOW . $id . ". " . TextFormat::GREEN . $cmd . "\n");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bEntity này không có bất kì lệnh nào");
														}
														return true;
													case "block":
													case "tile":
													case "blockid":
													case "tileid":
														if(isset($args[2])) {
															if($entity instanceof SlapperFallingSand) {
																$data = explode(":", $args[2]);
																$entity->setDataProperty(Entity::DATA_VARIANT, Entity::DATA_TYPE_INT, intval($data[0] ?? 1) | (intval($data[1] ?? 0) << 8));
																$entity->sendData($entity->getViewers());
																$sender->sendMessage($this->prefix . " §c• §bĐã update block !");
															} else {
																$sender->sendMessage($this->prefix . " §c• §bEntity đó không phải là block !");
															}
														} else {
															$sender->sendMessage($this->prefix . " §c• §bHãy nhập value");
														}
														return true;
														break;
													case "teleporthere":
													case "tphere":
													case "movehere":
													case "bringhere":
														$entity->teleport($sender);
														$sender->sendMessage($this->prefix . " §c• §bĐã teleport entity đến bạn !");
														$entity->respawnToAll();
														return true;
														break;
													case "teleportto":
													case "tpto":
													case "goto":
													case "teleport":
													case "tp":
														$sender->teleport($entity);
														$sender->sendMessage($this->prefix . " §c• §bĐã teleport bạn đến entity !");
														return true;
														break;
													case "scale":
													case "size":
														if(isset($args[2])) {
															$scale = floatval($args[2]);
															$entity->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $scale);
															$entity->sendData($entity->getViewers());
															$sender->sendMessage($this->prefix . " §c• §bĐã update size cho slapper");
														} else {
															$sender->sendMessage($this->prefix . " §c• §bHãy nhập value");
														}
														return true;
														break;
													default:
														$sender->sendMessage($this->prefix . " §c• §bLỗi lệnh");
														return true;
												}
											} else {
												$sender->sendMessage($this->helpHeader);
												foreach ($this->editArgs as $msgArg) {
													$sender->sendMessage(str_replace("<eid>", $args[0], (TextFormat::GREEN . " - " . $msgArg . "\n")));
												}
												return true;
											}
										} else {
											$sender->sendMessage($this->prefix . " §c• §bEntity này không thể xử lí bởi slapper !");
										}
									} else {
										$sender->sendMessage($this->prefix . " §c• §bEntity méo tồn tại");
									}
									return true;
								} else {
									$sender->sendMessage($this->helpHeader);
									foreach ($this->editArgs as $msgArg) {
										$sender->sendMessage(TextFormat::GREEN . " - " . $msgArg . "\n");
									}
									return true;
								}
							} else {
								$sender->sendMessage($this->noperm);
							}
							return true;
							break;
						case "help":
						case "?":
							$sender->sendMessage($this->helpHeader);
							foreach ($this->mainArgs as $msgArg) {
								$sender->sendMessage(TextFormat::GREEN . " - " . $msgArg . "\n");
							}
							return true;
							break;
						case "add":
						case "make":
						case "create":
						case "spawn":
						case "apawn":
						case "spanw":
							$type = array_shift($args);
							$name = str_replace("{color}", "§", str_replace("{line}", "\n", trim(implode(" ", $args))));
							if(empty(trim($type))) {
								$sender->sendMessage($this->prefix . " §c• §bHãy nhập loại entity !");
								return true;
							}
							if(empty($name)) {
								$name = $sender->getDisplayName();
							}
							$types = self::ENTITY_TYPES;
							$aliases = self::ENTITY_ALIASES;
							$chosenType = null;
							foreach ($types as $t) {
								if(strtolower($type) === strtolower($t)) {
									$chosenType = $t;
								}
							}
							if($chosenType === null) {
								foreach ($aliases as $alias => $t) {
									if(strtolower($type) === strtolower($alias)) {
										$chosenType = $t;
									}
								}
							}
							if($chosenType === null) {
								$sender->sendMessage($this->prefix . " §c• §bLỗi khi chọn entity");
								return true;
							}
							$nbt = $this->makeNBT($chosenType, $sender);
							/** @var SlapperEntity $entity */
							$entity = Entity::createEntity("Slapper" . $chosenType, $sender->getLevel(), $nbt);
							$entity->setNameTag($name);
							$entity->setNameTagVisible(true);
							$entity->setNameTagAlwaysVisible(true);
							$this->getServer()->getPluginManager()->callEvent(new SlapperCreationEvent($entity, "Slapper" . $chosenType, $sender, SlapperCreationEvent::CAUSE_COMMAND));
							$entity->spawnToAll();
							$sender->sendMessage($this->prefix  . $chosenType . " §c• §bĐã spawn slapper với tên " . TextFormat::WHITE . "\"" . TextFormat::BLUE . $name . TextFormat::WHITE . "\"" . TextFormat::GREEN . " §bvà id slapper là " . TextFormat::BLUE . $entity->getId());
							return true;
						default:
							$sender->sendMessage($this->prefix . " §c• §bLỗi lệnh slapper, hãy §c/slapper help§b để được trợ giúp");
							return true;
					}
				} else {
					$sender->sendMessage($this->prefix . " §c• §bCommand này luôn hoạt động trong game !");
					return true;
				}
		}
		return true;
	}

	private function makeNBT($type, Player $player) {
		$nbt = new CompoundTag;
		$nbt->Pos = new ListTag("Pos", [
			new DoubleTag(0, $player->getX()),
			new DoubleTag(1, $player->getY()),
			new DoubleTag(2, $player->getZ())
		]);
		$nbt->Motion = new ListTag("Motion", [
			new DoubleTag(0, 0),
			new DoubleTag(1, 0),
			new DoubleTag(2, 0)
		]);
		$nbt->Rotation = new ListTag("Rotation", [
			new FloatTag(0, $player->getYaw()),
			new FloatTag(1, $player->getPitch())
		]);
		$nbt->Health = new ShortTag("Health", 1);
		$nbt->Commands = new CompoundTag("Commands", []);
		$nbt->MenuName = new StringTag("MenuName", "");
		$nbt->SlapperVersion = new StringTag("SlapperVersion", $this->getDescription()->getVersion());
		if($type === "Human") {
			$player->saveNBT();
			$nbt->Inventory = clone $player->namedtag->Inventory;
			$nbt->Skin = new CompoundTag("Skin", ["Data" => new StringTag("Data", $player->getSkinData()), "Name" => new StringTag("Name", $player->getSkinId())]);
		}
		return $nbt;
	}

	/**
	 * @param EntityDamageEvent $event
	 * @ignoreCancelled true
	 */
	public function onEntityDamage(EntityDamageEvent $event) {
		$entity = $event->getEntity();
		if($entity instanceof SlapperEntity || $entity instanceof SlapperHuman) {
			$event->setCancelled(true);
			if(!$event instanceof EntityDamageByEntityEvent) {
				return;
			}
			$damager = $event->getDamager();
			if(!$damager instanceof Player) {
				return;
			}
			$this->getServer()->getPluginManager()->callEvent($event = new SlapperHitEvent($entity, $damager));
			if($event->isCancelled()) {
				return;
			}
			$damagerName = $damager->getName();
			if(isset($this->hitSessions[$damagerName])) {
				if($entity instanceof SlapperHuman) {
					$entity->getInventory()->clearAll();
				}
				$entity->close();
				unset($this->hitSessions[$damagerName]);
				$damager->sendMessage($this->prefix . " §c• §bĐã xóa bỏ entity");
				return;
			}
			if(isset($this->idSessions[$damagerName])) {
				$damager->sendMessage($this->prefix . " §c• §o§aEntity ID:§e " . $entity->getId());
				unset($this->idSessions[$damagerName]);
				return;
			}
			if(isset($entity->namedtag->Commands)) {
				$server = $this->getServer();
				foreach ($entity->namedtag->Commands as $cmd) {
					$server->dispatchCommand(new ConsoleCommandSender(), str_replace("{player}", $damagerName, $cmd));
				}
			}
		}
	}

	public function onEntitySpawn(EntitySpawnEvent $ev) {
		$entity = $ev->getEntity();
		if($entity instanceof SlapperEntity || $entity instanceof SlapperHuman) {
			$clearLagg = $this->getServer()->getPluginManager()->getPlugin("ClearLagg");
			if($clearLagg !== null) {
				$clearLagg->exemptEntity($entity);
			}
		}
	}
}
