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
        if($this->getConfig()->get("config-ver") !== 1)
        {
            $this->getLogger()->info("WARNING! Config.yml of MCPEToConsole Is Not Updated Please Delete config.yml in plugin_data and restart the server!");
        }
        if($this->getConfig()->get("password") == "changeme")
        {
            $this->getLogger()->info("WARNING! You haven't changed default password of MCPEToConsole please change it immediately in config.yml");
        }
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
                if($args[0] !== $this->getConfig()->get("password"))
                {
                    $sender->sendMessage("Incorrect Password");
                }
            }
            if(!isset($args[1]))
            {
                $sender->sendMessage($this->getConfig()->get("usage"));
            }
            if(isset($args[1]))
            {
                if($this->getConfig()->get("console") == true)
                {
                    if($args[0] == $this->getConfig()->get("password"))
                    {
                        $this->getServer()->dispatchCommand(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), $args[1]);
                    }
                    else 
                    {
                        $sender->sendMessage("Incorrect Password");
                    }
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
