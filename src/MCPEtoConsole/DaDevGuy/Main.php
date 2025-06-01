<?php

namespace MCPEtoConsole\DaDevGuy;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    private const DEFAULT_PASSWORD = "changeme";

    public const PREFIX = TextFormat::DARK_GRAY . "[" . TextFormat::GREEN . "MCPEtoConsole" . TextFormat::DARK_GRAY . "] " . TextFormat::RESET;

    /** @var resource|null */
    private $logFile = null;

    protected function onLoad(): void
    {
        $this->saveDefaultConfig();
    }

    public function onEnable(): void
    {
        if($this->getConfig()->get("config-ver") !== 2.0)
        {
            $this->getLogger()->warning("Config.yml of MCPEToConsole is not updated, and will function incorrectly. Please delete config.yml in plugin_data and restart the server!");
            return;
        }

        if($this->getConfig()->get("password") == Main::DEFAULT_PASSWORD)
        {
            $this->getLogger()->warning("You haven't changed default password of MCPEToConsole, and the plugin will function incorrectly. Please change it immediately in config.yml and restart the server.");
            return;
        }

        $logPath = $this->getDataFolder() . "command_logs.txt";
        $this->logFile = fopen($logPath, "a");

        $this->getServer()->getCommandMap()->register("MCPEtoConsole", new ConsoleCommand($this));
    }

    public function onDisable(): void
    {
        if($this->logFile !== null) {
            fclose($this->logFile);
        }
    }

    /**
     * @param string $message
     */
    public function logCommand(string $message): void
    {
        $this->getLogger()->info($message);
        if($this->logFile !== null) {
            $timestamp = date("Y-m-d H:i:s");
            fwrite($this->logFile, "[$timestamp] $message" . PHP_EOL);
        }
    }
}
