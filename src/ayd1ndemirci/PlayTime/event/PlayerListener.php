<?php

/*
                 _ __           _                _          _
                | /_ |         | |              (_)        (_)
  __ _ _   _  __| || |_ __   __| | ___ _ __ ___  _ _ __ ___ _
 / _` | | | |/ _` || | '_ \ / _` |/ _ \ '_ ` _ \| | '__/ __| |
| (_| | |_| | (_| || | | | | (_| |  __/ | | | | | | | | (__| |
 \__,_|\__, |\__,_||_|_| |_|\__,_|\___|_| |_| |_|_|_|  \___|_|
        __/ |
       |___/
 */

namespace ayd1ndemirci\PlayTime\event;

use ayd1ndemirci\PlayTime\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerListener implements Listener
{
    public static array $join_time = [];

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        if (empty(Main::$main->getProvider()->getPlayer($player->getName()))) {
            Main::$main->getProvider()->addPlayer($player->getName(), 0);
        }
        self::$join_time[$player->getName()] = time();
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();
        $total_time = time() - self::$join_time[$player->getName()];
        foreach (Main::$main->getProvider()->getPlayer($player->getName()) as $value) {
            Main::$main->getProvider()->addTime($player->getName(), $value["playTime"] + $total_time);
        }
    }
}