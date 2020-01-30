<?php


namespace ItsGabry\NanoCombinerGUI;

use onebone\economyapi\EconomyAPI;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;


class Main extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch (strtolower($command->getName())) {
            case "combiner":
                if ($sender instanceof Player) {
                    $menu = InvMenu::create(InvMenu::TYPE_CHEST);
                    $menu->setInventoryCloseListener(function(Player $player, Inventory $inventory) {
                        if($inventory->getItem(10)->isNull() xor $inventory->getItem(16)->isNull()) {
                                $player->getInventory()->addItem($inventory->getItem(10));
                                $player->getInventory()->addItem($inventory->getItem(16));
                        }elseif(!($inventory->getItem(10)->isNull() and $inventory->getItem(16)->isNull())) {
                            if($this->EconomyAPEEE()->myMoney($player) < $this->getConfig()->get("Cost")) {
                                $player->getInventory()->addItem($inventory->getItem(10));
                                $player->getInventory()->addItem($inventory->getItem(16));
                            }
                        }
                    });
                    $menu->getInventory()->setContents([
                        0 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        1 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        2 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        3 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        4 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        5 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        6 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        7 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        8 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        9 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        11 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        12 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        13 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        14 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        15 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        17 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        18 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        19 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        20 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        21 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        22 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        23 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        24 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        25 => ItemFactory::get(Item::STAINED_GLASS_PANE, 14),
                        26 => ItemFactory::get(Item::STAINED_GLASS_PANE, 5),

                    ]);

                    $menu->send($sender, TextFormat::GREEN . TextFormat::BOLD . TextFormat::ITALIC . "CombinerGUI");
                    $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_USE, 100);
                    $menu->setListener(function (Player $player, Item $itemClicked, Item $itemClickedWith, SlotChangeAction $action): bool {
                        $item = $action->getInventory()->getItem(10);
                        $item1 = $action->getInventory()->getItem(10);
                        $item2 = $action->getInventory()->getItem(16);
                        $IncompatibleBlaze = [314, 301];
                        $IncompatibleGrappling = [305]; //313
                        $IncompatibleGrow = [414]; //415
                        $IncompatibleHoming = [311,314,301]; //316
                        $IncompatiblePorkified = [301]; //314
                        $IncompatibleFortune = [16]; //18

                        if($action->getSlot() == 10) {
                            $item1 = $action->getInventory()->getItem(10);
                        }elseif($action->getSlot() == 16) {
                            $item2 = $action->getInventory()->getItem(16);
                        }
                        if ($action->getSlot() == 26) {
                            $getEnchantments = $item1->getEnchantments();
                            $getEnchantments1 = $item2->getEnchantments();
                            $player->getLevel()->broadcastLevelEvent($player, LevelEventPacket::EVENT_CAULDRON_CLEAN_BANNER, 100);
                            if ($this->EconomyAPEEE()->myMoney($player) >= $this->getConfig()->get("Cost")) {
                                if ($item1->isNull() === false) {
                                    if ($item2->isNull() === false) {
                                        if ($item1->hasEnchantments() and $item2->hasEnchantments()) {
                                            if ($item1->getId() === $item2->getId()) {
                                                foreach ($getEnchantments as $enchantment) {
                                                    foreach ($getEnchantments1 as $enchantment1) {
                                                        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantment->getId()), $enchantment->getLevel()));
                                                        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantment1->getId()), $enchantment1->getLevel()));
                                                        if ($enchantment->getId() === 311 and (in_array($enchantment1->getId(), $IncompatibleBlaze)) or ($enchantment1->getId() === 311 and (in_array($enchantment->getId(), $IncompatibleBlaze)))) {
                                                            $player->removeWindow($action->getInventory());
                                                            $player->sendMessage(TextFormat::RED . "Incompatible enchantments");
                                                            return false;
                                                        }elseif ($enchantment->getId() === 313 and (in_array($enchantment1->getId(), $IncompatibleGrappling)) or ($enchantment1->getId() === 313 and (in_array($enchantment->getId(), $IncompatibleGrappling)))) {
                                                            $player->removeWindow($action->getInventory());
                                                            $player->sendMessage(TextFormat::RED . "Incompatible enchantments");
                                                            return false;
                                                        }elseif ($enchantment->getId() === 415 and (in_array($enchantment1->getId(), $IncompatibleGrow)) or ($enchantment1->getId() === 415 and (in_array($enchantment->getId(), $IncompatibleGrow)))) {
                                                            $player->removeWindow($action->getInventory());
                                                            $player->sendMessage(TextFormat::RED . "Incompatible enchantments");
                                                            return false;
                                                        }elseif ($enchantment->getId() === 316 and (in_array($enchantment1->getId(), $IncompatibleHoming)) or ($enchantment1->getId() === 316 and (in_array($enchantment->getId(), $IncompatibleHoming)))) {
                                                            $player->removeWindow($action->getInventory());
                                                            $player->sendMessage(TextFormat::RED . "Incompatible enchantments");
                                                            return false;
                                                        }elseif ($enchantment->getId() === 314 and (in_array($enchantment1->getId(), $IncompatiblePorkified)) or ($enchantment1->getId() === 314 and (in_array($enchantment->getId(), $IncompatiblePorkified)))) {
                                                            $player->removeWindow($action->getInventory());
                                                            $player->sendMessage(TextFormat::RED . "Incompatible enchantments");
                                                            return false;
                                                        }elseif ($enchantment->getId() === 18 and (in_array($enchantment1->getId(), $IncompatibleFortune)) or ($enchantment1->getId() === 18 and (in_array($enchantment->getId(), $IncompatibleFortune)))) {
                                                            $player->removeWindow($action->getInventory());
                                                            $player->sendMessage(TextFormat::RED . "Incompatible enchantments");
                                                            return false;
                                                        }
                                                    }
                                                }
                                                foreach ($item1->getEnchantments() as $b) {
                                                    foreach ($item2->getEnchantments() as $c) {
                                                        if ($b->getId() === $c->getId()) {
                                                            $level1 = $b->getLevel();
                                                            $level2 = $c->getLevel();
                                                            $level = $level1 + $level2;
                                                            if($level <= $c->getType()->getMaxLevel()) {
                                                                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($c->getId()), $level));
                                                            }elseif($level > $c->getType()->getMaxLevel()){
                                                                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($c->getId()), $c->getType()->getMaxLevel()));
                                                                    $player->sendMessage(TextFormat::RED . "You have reached the maximum level. The enchant has been set to the maximum possible level");
                                                            }
                                                        }
                                                    }
                                                }
                                                $this->EconomyAPEEE()->reduceMoney($player, $this->getConfig()->get("Cost"));
                                                $player->removeWindow($action->getInventory());
                                                $player->getInventory()->addItem($item);
                                                $player->sendMessage(TextFormat::GREEN . "You have successfully combined the enchantments for" . " " . $this->getConfig()->get("Cost") . " " . "money");


                                            }else{
                                                $player->removeWindow($action->getInventory());
                                                $player->sendMessage(TextFormat::RED . "Both items must be the same");
                                            }


                                        } else {
                                            $player->removeWindow($action->getInventory());
                                            $player->sendMessage(TextFormat::RED . "Both items must have enchantments");
                                        }


                                    } else {
                                        $player->removeWindow($action->getInventory());
                                        $player->sendMessage(TextFormat::RED . "There must be two items");
                                    }

                                } else {
                                    $player->removeWindow($action->getInventory());
                                    $player->sendMessage(TextFormat::RED . "There must be two items");
                                }


                            }elseif($this->EconomyAPEEE()->myMoney($player) < $this->getConfig()->get("Cost")){
                                $player->removeWindow($action->getInventory());
                                $player->sendMessage(TextFormat::RED . "You don't have enough money!");

                            }

                        }

                        if(in_array($action->getSlot(), [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 14, 15, 17, 18, 19, 20, 21, 22, 23, 24, 25])) {
                            $player->removeWindow($action->getInventory());
                        }

                        if (in_array($action->getSlot(), [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 14, 15, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26])) {
                            return false;
                        }else{
                            return true;
                        }
                    });

                }

                return true;

        }


    }

    /**
     * @return EconomyAPI
     */
    public function EconomyAPEEE() : \onebone\economyapi\EconomyAPI {
        return $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }


}
