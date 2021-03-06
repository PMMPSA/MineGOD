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
	public $prefix = (TextFormat::LIGHT_PURPLE . "???" . TextFormat::AQUA . "Slapper Vi???t H??a" . TextFormat::LIGHT_PURPLE . "???");
	public $noperm = (TextFormat::LIGHT_PURPLE . "???" . TextFormat::AQUA . "Slapper Vi???t H??a" . TextFormat::LIGHT_PURPLE . " ???");
	public $helpHeader =
		(
			TextFormat::AQUA . "---------- " .
			TextFormat::LIGHT_PURPLE . "???" . TextFormat::YELLOW . "Slapper Tr??? Gi??p" . TextFormat::LIGHT_PURPLE . "???" .
			TextFormat::AQUA . "----------"
		);
	public $mainArgs = [
		"??e??? ??dS??? d???ng ??c/slapper help??d n???u kh??ng bi???t l???nh ??e???",
		"??e??? ??dS??? d???ng ??c/slapper spawn <type> [name]??d ????? t???o ra slapper ??e???",
		"??e??? ??dS??? d???ng ??c/slapper edit [id] [args...]??d ????? ch???nh s???a slapper ??e???",
		"??e??? ??dS??? d???ng ??c/slapper id??d ????? xem id c???a slapper ??e???",
		"??e??? ??dS??? d???ng ??c/slapper remove [id]??d ????? x??a slapper ??e???",
		"??e??? ??dS??? d???ng ??c/slapper version??d ????? xem version slapper ??e???",
		"??e??? ??dS??? d???ng ??c/slapper cancel??d ????? t??? ch???i 1 l???nh slapper ??e???",
	];
	public $editArgs = [
		"??e??? ??aN??n ??? ??dS??? d???ng ??c/slapper edit <eid> helmet <id>??d ????? ch???nh s???a n??n cho slapper ??e???",
		"??e??? ??aGi??p ??? ??dS??? d???ng ??c/slapper edit <eid> chestplate <id>??d ????? ch???nh s???a gi??p cho slapper ??e???",
		"??e??? ??aQu???n ??? ??dS??? d???ng ??c/slapper edit <eid> leggings <id>??d ????? ch???nh s???a qu???n cho slapper ??e???",
		"??e??? ??aGi??y ??? ??dS??? d???ng ??c/slapper edit <eid> boots <id>??d ????? ch???nh s???a gi??y cho slapper ??e???",
		"??e??? ??aSkin ??? ??dS??? d???ng ??c/slapper edit <eid> skin??d ????? ch???nh s???a skin cho slapper ??e???",
		"??e??? ??aT??n ??? ??dS??? d???ng ??c/slapper edit <eid> name <name>??d ????? ch???nh s???a t??n cho slapper ??e???",
		"??e??? ??aT??n hi???n th??? ??? ??dS??? d???ng ??c/slapper edit <eid> namevisibility <never/hover/always>??d ????? ch???nh s???a t??n hi???n th??? cho slapper ??e???",
		"??e??? ??aTh??m L???nh ??? ??dS??? d???ng ??c/slapper edit <eid> addcommand <command>??d ????? th??m l???nh v??o slapper ??e???",
		"??e??? ??aX??a L???nh ??? ??dS??? d???ng ??c/slapper edit <eid> delcommand <command>??d ????? x??a l???nh cho slapper ??e???",
		"??e??? ??aDanh s??ch l???nh ??? ??dS??? d???ng ??c/slapper edit <eid> listcommands??d ????? xem l???nh ???? th??m v??o slapper ??e???",
		"??e??? ??aBlock ?? ??? ??dS??? d???ng ??c/slapper edit <eid> block <id[:meta]>??d ????? ch???nh s???a block ??i xu???ng/??i l??n ??e???",
		"??e??? ??aSlapper Size ??? ??dS??? d???ng ??c/slapper edit <eid> scale <size>??d ????? ch???nh s???a size slapper ??e???",
		"??e??? ??aTeleport Here ??? ??dS??? d???ng ??c/slapper edit <eid> tphere??d ????? teleport slapper ?????n ng?????i ch??i ??e???",
		"??e??? ??aTeleport To ??? ??dS??? d???ng ??c/slapper edit <eid> tpto??d ????? teleport ?????n slapper ??e???",
		"??e??? ??aMenu T??n ??? ??dS??? d???ng ??c/slapper edit <eid> menuname <name/remove>??d ????? ch???nh s???a t??n slapper tr??n menu online ??e???"
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
					$sender->sendMessage($this->prefix . " ??c??? ??bH??y ?????t t??n cho slapper ho???c command !");
					return true;
				}
				$player = $this->getServer()->getPlayer(array_shift($args));
				if($player instanceof Player) {
					$this->getServer()->dispatchCommand($player, trim(implode(" ", $args)));
					return true;
				} else {
					$sender->sendMessage($this->prefix . " ??c??? ??bKh??ng th??? t??m th???y ng?????i ch??i !");
					return true;
				}
				break;
			case "slapper":
				if($sender instanceof Player) {
					if(!(isset($args[0]))) {
						if($sender->hasPermission("slapper.command") || $sender->hasPermission("slapper")) {
							$sender->sendMessage($this->prefix . " ??c??? ??bS??? d???ng ??c/slapper help??b n???u b???n kh??ng bi???t l???nh");
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
								$sender->sendMessage($this->prefix . " ??c??? ??bTap v??o slapper ????? xem id !");
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
							$sender->sendMessage($this->prefix . " ??c??? ??bT??? ch???i l???nh !");
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
											$sender->sendMessage($this->prefix . " ??c??? ??bEntity ???? b??? x??a b??? !");
										} else {
											$sender->sendMessage($this->prefix . " ??c??? Entity n??y kh??ng th??? x??? l?? b???i slapper !");
										}
									} else {
										$sender->sendMessage($this->prefix . " ??c??? ??bEntity n??y kh??ng t???n t???i !");
									}
									return true;
								}
								$this->hitSessions[$sender->getName()] = true;
								$sender->sendMessage($this->prefix . " ??c??? ??bTap v??o slapper ????? x??a b??? entity !");
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
																$sender->sendMessage($this->prefix . " ??c??? ??b???? update m?? cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p id item v??o !");
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bOops ! Entity n??y kh??ng th??? m???c gi??p");
														}
														return true;
													case "chest":
													case "shirt":
													case "chestplate":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setChestplate(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " ??c??? ??b???? update gi??p cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p id item v??o !");
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bOops ! Entity n??y kh??ng th??? m???c gi??p");
														}
														return true;
													case "pants":
													case "legs":
													case "leggings":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setLeggings(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " ??c??? ??b???? update qu???n cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p id item v??o !");
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bOops ! Entity n??y kh??ng th??? m???c gi??p");
														}
														return true;
													case "feet":
													case "boots":
													case "shoes":
														if($entity instanceof SlapperHuman) {
															if(isset($args[2])) {
																$entity->getInventory()->setBoots(Item::fromString($args[2]));
																$sender->sendMessage($this->prefix . " ??c??? ??b???? update gi??y cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p id item v??o !");
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bOops ! Entity n??y kh??ng th??? m???c gi??p");
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
																$sender->sendMessage($this->prefix . " ??c??? ??b???? update item cho slapper");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p id item v??o !");
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bOops ! Entity n??y kh??ng th??? m???c gi??p");
														}
														return true;
													case "setskin":
													case "changeskin":
													case "editskin";
													case "skin":
														if($entity instanceof SlapperHuman) {
															$entity->setSkin($sender->getSkinData(), $sender->getSkinId());
															$entity->sendData($entity->getViewers());
															$sender->sendMessage($this->prefix . " ??c??? ??b???? update skin cho slapper");
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bR???t ti???c ! Entity n??y kh??ng th??? thay skin");
														}
														return true;
													case "name":
													case "customname":
														if(isset($args[2])) {
															array_shift($args);
															array_shift($args);
															$entity->setNameTag(trim(implode(" ", $args)));
															$entity->sendData($entity->getViewers());
															$sender->sendMessage($this->prefix . " ??c??? ??b???? update t??n cho slapper");
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p t??n slapper v??o");
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
																$sender->sendMessage($this->prefix . " ??c??? ??bMenu t??n update");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p t??n cho menu !");
																return true;
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bEntity n??y kh??ng th??? c?? menu t??n !");
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
																	$sender->sendMessage($this->prefix . " ??c??? ??bT??n hi???n th??? ???? update !");
																	return true;
																	break;
																case "h":
																case "hover":
																case "lookingat":
																case "onhover":
																	$entity->setNameTagVisible(true);
																	$entity->setNameTagAlwaysVisible(false);
																	$entity->sendData($entity->getViewers());
																	$sender->sendMessage($this->prefix . " ??c??? ??bT??n hi???n th??? ???? update !");
																	return true;
																	break;
																case "n":
																case "never":
																case "no":
																case "0":
																	$entity->setNameTagVisible(false);
																	$entity->setNameTagAlwaysVisible(false);
																	$entity->sendData($entity->getViewers());
																	$sender->sendMessage($this->prefix . " ??c??? ??bT??n hi???n th??? ???? update !");
																	return true;
																	break;
																default:
																	$sender->sendMessage($this->prefix . " ??c??? ??bH??y ??i???n c??c lo???i n??y \"always\", \"hover\", ??bho???c \"never\".");
																	return true;
																	break;
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bH??y ??i???n c??c lo???i n??y \"always\", \"hover\", ??bho???c \"never\".");
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
																$sender->sendMessage($this->prefix . " ??c??? ??bCommand n??y ???? ???????c add v??o slapper !");
																return true;
															}
															$entity->namedtag->Commands[$input] = new StringTag($input, $input);
															$sender->sendMessage($this->prefix . " ??c??? ??b???? add th??nh c??ng command !");
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p command v??o !");
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
															$sender->sendMessage($this->prefix . " ??c??? ??b???? x??a th??nh c??ng command !");
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p command v??o !");
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
															$sender->sendMessage($this->prefix . " ??c??? ??bEntity n??y kh??ng c?? b???t k?? l???nh n??o");
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
																$sender->sendMessage($this->prefix . " ??c??? ??b???? update block !");
															} else {
																$sender->sendMessage($this->prefix . " ??c??? ??bEntity ???? kh??ng ph???i l?? block !");
															}
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p value");
														}
														return true;
														break;
													case "teleporthere":
													case "tphere":
													case "movehere":
													case "bringhere":
														$entity->teleport($sender);
														$sender->sendMessage($this->prefix . " ??c??? ??b???? teleport entity ?????n b???n !");
														$entity->respawnToAll();
														return true;
														break;
													case "teleportto":
													case "tpto":
													case "goto":
													case "teleport":
													case "tp":
														$sender->teleport($entity);
														$sender->sendMessage($this->prefix . " ??c??? ??b???? teleport b???n ?????n entity !");
														return true;
														break;
													case "scale":
													case "size":
														if(isset($args[2])) {
															$scale = floatval($args[2]);
															$entity->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $scale);
															$entity->sendData($entity->getViewers());
															$sender->sendMessage($this->prefix . " ??c??? ??b???? update size cho slapper");
														} else {
															$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p value");
														}
														return true;
														break;
													default:
														$sender->sendMessage($this->prefix . " ??c??? ??bL???i l???nh");
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
											$sender->sendMessage($this->prefix . " ??c??? ??bEntity n??y kh??ng th??? x??? l?? b???i slapper !");
										}
									} else {
										$sender->sendMessage($this->prefix . " ??c??? ??bEntity m??o t???n t???i");
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
							$name = str_replace("{color}", "??", str_replace("{line}", "\n", trim(implode(" ", $args))));
							if(empty(trim($type))) {
								$sender->sendMessage($this->prefix . " ??c??? ??bH??y nh???p lo???i entity !");
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
								$sender->sendMessage($this->prefix . " ??c??? ??bL???i khi ch???n entity");
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
							$sender->sendMessage($this->prefix  . $chosenType . " ??c??? ??b???? spawn slapper v???i t??n " . TextFormat::WHITE . "\"" . TextFormat::BLUE . $name . TextFormat::WHITE . "\"" . TextFormat::GREEN . " ??bv?? id slapper l?? " . TextFormat::BLUE . $entity->getId());
							return true;
						default:
							$sender->sendMessage($this->prefix . " ??c??? ??bL???i l???nh slapper, h??y ??c/slapper help??b ????? ???????c tr??? gi??p");
							return true;
					}
				} else {
					$sender->sendMessage($this->prefix . " ??c??? ??bCommand n??y lu??n ho???t ?????ng trong game !");
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
				$damager->sendMessage($this->prefix . " ??c??? ??b???? x??a b??? entity");
				return;
			}
			if(isset($this->idSessions[$damagerName])) {
				$damager->sendMessage($this->prefix . " ??c??? ??o??aEntity ID:??e " . $entity->getId());
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
