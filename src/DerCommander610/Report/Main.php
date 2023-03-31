<?php

namespace DerCommander610\Report;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{

        switch($command->getName()){
            case "report":
              if($sender instanceof Player){
                 $this->reportUI($player);
              }  else {
                  $sender->sendMessage("So?");
              }
             break;
        }
    return true;
    }

    public function reportUI($player){
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null)){
            if($data === null) {
            return true;

                }
                if($data[0] == null){
                    $player->sendMessage("§cPLease write the PlayerName!");
                }
                if($data[1] == null){
                    $player->sendMessage("§cPLease write the Reason!");
                }
                $player->sendMessage("§aReport was sended on the Admins!");
                foreach($this->getServer()->getOnlinePlayers() as $player) {
                    if($player->hasPermission("report.view")){
                        $player->sendMessage("§cA new Report received!\nName: " . $data[0] . "\n Reason: " . $data[1] . "\n Reporter: " . $player->getName());
                    }
                }
        });
        $form->setTitle($this->getConfig()->get("ReportTitle"));
        $form->addInput("Write the Playername");
        $form->addInput("Write the reason");
        $form->sendToPlayer($player);
        return $form;

    }
}