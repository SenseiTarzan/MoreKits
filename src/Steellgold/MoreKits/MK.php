<?php

/*
 * Copyright (c) 2021. Gaëtan H
 * https://github.com/Steellgold
 */

namespace Steellgold\MoreKits;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use pocketmine\plugin\PluginBase;


class MK extends PluginBase {
    private string $version = "1.0";
    private \SQLite3 $database;
    public static MK $instance;

    /**
     * @throws HookAlreadyRegistered
     */
    public function onEnable() {
        self::setInstance($this);

        if ($this->getConfig()->exists("version") and $this->getConfig()->get("version") !== $this->version) {
            $this->getLogger()->alert("The plug-in configuration has been modified since an update, your old configuration has been renamed to old_config.yml");
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "old_config.yml");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        /**
         * required by commando
         */
        if(!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
    }

    public static function getInstance() : MK {
        return self::$instance;
    }

    public static function setInstance($instance): void {
        self::$instance = $instance;
    }

    public function getDatabase() : \SQLite3 {
        if($this->database == null){
            $this->database = new \SQLite3($this->getDataFolder() . "kits.db");
            return $this->database;
        }

        return $this->database;
    }
}