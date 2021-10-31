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
}