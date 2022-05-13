<?php

namespace MCPEtoConsole\DaDevGuy;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public function onEnable(): void
    {
        $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if($command->getName() === "console")
        {
            if(!$sender instanceof Player)
            {
                $sender->sendMessage("Please Use This Command In-Game!");
            }
            if(!isset($args[0]))
            {
                $sender->sendMessage($this->getConfig()->get("usage"));
            }
            if(isset($args[0]))
            {
                if($this->getConfig()->get("console") == true){
                    $this->getServer()->dispatchCommand(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), $args[0]);
            }
            else
            {
                $this->getLogger()->info("console is not turned on in config.yml");
                $sender->sendMessage("console is not turned on in config.yml");
            }
        }
        return true;
    }
    return false;
   }
}
