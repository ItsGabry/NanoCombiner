<?php


namespace ItsGabry\NanoCombinerGUI;

use onebone\economyapi\EconomyAPI;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
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
                    $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_USE, (int)100);
                    $menu->setListener(function (Player $player, Item $itemClicked, Item $itemClickedWith, SlotChangeAction $action): bool {
                        $item = $action->getInventory()->getItem(10);
                        $item1 = $action->getInventory()->getItem(10);
                        $item2 = $action->getInventory()->getItem(16);
                        if ($action->getSlot() == 26) {
                            if ($action->getInventory()->getItem(10)->isNull() == false) {
                                if ($action->getInventory()->getItem(16)->isNull() == false) {
                                    if ($item1->hasEnchantments() and $item2->hasEnchantments()) {
                                        $getEnchantments = $action->getInventory()->getItem(10)->getEnchantments();
                                        $getEnchantments1 = $action->getInventory()->getItem(16)->getEnchantments();
                                        $player->getLevel()->broadcastLevelEvent($player, LevelEventPacket::EVENT_CAULDRON_CLEAN_BANNER, (int)100);
                                        foreach($getEnchantments as $enchantment) {
                                            foreach ($getEnchantments1 as $enchantment1) {
                                                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantment->getId()), $enchantment->getLevel()));
                                                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantment1->getId()), $enchantment1->getLevel()));
                                                if(in_array($enchantment, $getEnchantments)) {
                                                    foreach($item1->getEnchantments() as $b) {
                                                        foreach ($item2->getEnchantments() as $c ) {
                                                            if($b->getId() == $c->getId()) {
                                                                $level1 = $b->getLevel();
                                                                $level2 = $c->getLevel();
                                                                $level = $level1 + $level2;
                                                                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantment->getId()), $enchantment->getLevel()));
                                                                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($enchantment1->getId()), $enchantment1->getLevel()));
                                                                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment($c->getId()),$level));
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }

                                        $player->removeWindow($action->getInventory());
                                        $player->getInventory()->addItem($item);
                                        $player->sendMessage(TextFormat::GREEN . "Hai combinato correttamente gli enchant");

                                    } else {
                                        $player->removeWindow($action->getInventory());
                                        $player->sendMessage(TextFormat::RED . "Entrambi gli item devono avere degli Enchant!");
                                        $player->getInventory()->addItem($item1);
                                        $player->getInventory()->addItem($item2);
                                    }


                            } else {
                                $player->removeWindow($action->getInventory());
                                $player->sendMessage(TextFormat::RED . "Devi inserire due items");
                                $player->getInventory()->addItem($item1);
                                $player->getInventory()->addItem($item2);
                            }
                        }else{
                                $player->removeWindow($action->getInventory());
                                $player->sendMessage(TextFormat::RED . "Devi inserire due items");
                                $player->getInventory()->addItem($item1);
                                $player->getInventory()->addItem($item2);
                            }

                    }
                        if (in_array($action->getSlot(), [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 14, 15, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26])) {
                            return false;
                        } else {
                            return true;
                        }
                    });
                }
                return true;
        }

    }

    public function onJoin(PlayerJoinEvent $event) {
        $item = $item = ItemFactory::get(ItemIds::DIAMOND_SWORD);
        $item1 = ItemFactory::get(ItemIds::DIAMOND_SWORD);
        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9),1));
        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12),1));
        $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13),1));
        $item1->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9),1));
        $item1->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12),1));
        $item1->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13),1));
        $event->getPlayer()->getInventory()->addItem($item);
        $event->getPlayer()->getInventory()->addItem($item1);
    }
}
