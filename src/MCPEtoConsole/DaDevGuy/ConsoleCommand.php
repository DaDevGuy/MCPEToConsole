<?php

namespace MCPEtoConsole\DaDevGuy;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;

class ConsoleCommand extends Command implements PluginOwned
{
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("console");

        $this->setDescription("Send Commands To Console!");
        $this->setAliases(["c"]);
        $this->setUsage($plugin->getConfig()->get("usage"));
        $this->setPermission("mcpetoconsole.cmd");

        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;

        if (!$sender instanceof Player) {
            $sender->sendMessage(Main::PREFIX . TextFormat::RED . "Please Use This Command In-Game!");
            return;
        }

        if (count($args) < 1) {
            $sender->sendMessage($this->getUsage());
            return;
        }

        if ($args[0] !== $this->plugin->getConfig()->get("password")) {
            $sender->sendMessage(Main::PREFIX . TextFormat::RED . "Incorrect Password");
            return;
        }

        if (!$this->plugin->getConfig()->get("console")){
            $this->plugin->getLogger()->notice("Console is not turned on in config.yml");
            $sender->sendMessage(Main::PREFIX . TextFormat::AQUA . "Console is not turned on in config.yml");
            return;
        }

        if ($this->plugin->getConfig()->get("console-logging")) $this->plugin->getLogger()->info("Executing command sent by " . TextFormat::AQUA . $sender->getName() . TextFormat::RESET . ": " . implode(" ", array_slice($args, 1)));


        $this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender($this->plugin->getServer(), $this->plugin->getServer()->getLanguage()), implode(" ", array_slice($args, 1)));
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}