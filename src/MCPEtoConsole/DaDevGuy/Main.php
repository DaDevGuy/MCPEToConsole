<?php

namespace MCPEtoConsole\DaDevGuy;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    private const DEFAULT_PASSWORD = "changeme";

    public const PREFIX = TextFormat::DARK_GRAY . "[" . TextFormat::GREEN . "MCPEtoConsole" . TextFormat::DARK_GRAY . "] " . TextFormat::RESET;

    protected function onLoad(): void
    {
        $this->saveDefaultConfig();
    }

    public function onEnable(): void
    {
        if($this->getConfig()->get("config-ver") !== 1.1)
        {
            $this->getLogger()->warning("Config.yml of MCPEToConsole is not updated, and will function incorrectly. Please delete config.yml in plugin_data and restart the server!");
            return;
        }

        if($this->getConfig()->get("password") == Main::DEFAULT_PASSWORD)
        {
            $this->getLogger()->warning("You haven't changed default password of MCPEToConsole, and the plugin will function incorrectly. Please change it immediately in config.yml and restart the server.");
            return;
        }

        $this->getServer()->getCommandMap()->register("MCPEtoConsole", new ConsoleCommand($this));
    }
}
