<?php
/*       
    _____                      _____                 
  / ____|                    |  __ \                
 | |  __ _ __ __ _ _ __   ___| |  | | _____   _____ 
 | | |_ | '__/ _` | '_ \ / _ \ |  | |/ _ \ \ / / __|
 | |__| | | | (_| | |_) |  __/ |__| |  __/\ V /\__ \
  \_____|_|  \__,_| .__/ \___|_____/ \___| \_/ |___/
                  | |                               
                  |_|                                                  
                                                   
Copyright (C) 2020  GrapeDevs (github.com/GrapeDevs)
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/
namespace Taco\GrapeParticlesUI;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
class Loader extends PluginBase implements Listener {
    public $players = [];
    public $waterdrip = array("waterdrip");
    public $flame = array("flame");
    public $hearts = array("hearts");
    public $name = array();
    public function onEnable() {
        $this->getScheduler()->scheduleRepeatingTask(new ParticlesTask($this), 5);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        $name = $sender->getName();
        switch ($command->getName()) {
            case "grapepui":
                if (!$sender->hasPermission("gpui.form")) {
                    $sender->sendMessage("§b[GrapeParticleUI]\n§aNo Permissions");
                    return true;
                }
                $this->openParticlesForm($sender);
                break;
        }
        return true;
    }
    public function openParticlesForm($player) {
        $name = $player->getName();
        if ($player->hasPermission("gpui.waterdrip")) {
            $msg1 = "§aUNLOCKED";
        }else{
            $msg1 = "§cLOCKED";
        }
        if ($player->hasPermission("gpui.flame")) {
            $msg2 = "§aUNLOCKED";
        }else{
            $msg2 = "§cLOCKED";
        }
        if ($player->hasPermission("gpui.heart")) {
            $msg3 = "§aUNLOCKED";
        }else{
            $msg3 = "§cLOCKED";
        }
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch($result) {
                case 0:
                    if (!$player->hasPermission("gpui.waterdrip")) {
                        $sender->sendMessage("§b[GrapeParticleUI]\n§aNo Permissions");
                        return true;
                    }
                    if (!in_array($name, $this->waterdrip)) {
                        $this->waterdrip[] = $name;
                        $sender->sendMessage("§b[GrapeParticleUI]\n§aEnabled WaterDrip Particle");
                    }else{
                        unset($this->waterdrip[array_search($name, $this->waterdrip)]);
                        $sender->sendMessage("§b[GrapeParticleUI]\n§aDisabled WaterDrip Particle");
                    }
                    break;
                    case 1:
                        if (!$player->hasPermission("gpui.flame")) {
                            $sender->sendMessage("§b[GrapeParticleUI]\n§aNo Permissions");
                            return true;
                        }
                        if (!in_array($name, $this->flame)) {
                            $this->flame[] = $name;
                            $sender->sendMessage("§b[GrapeParticleUI]\n§aEnabled Flame Particle");
                        }else{
                            unset($this->flame[array_search($name, $this->flame)]);
                            $sender->sendMessage("§b[GrapeParticleUI]\n§aDisabled Flame Particle");
                        }
                        break;
                        case 2:
                            if (!$player->hasPermission("gpui.heart")) {
                                $sender->sendMessage("§b[GrapeParticleUI]\n§aNo Permissions");
                                return true;
                            }
                            if (!in_array($name, $this->hearts)) {
                                $this->hearts[] = $name;
                                $sender->sendMessage("§b[GrapeParticleUI]\n§aEnabled Hearts Particle");
                            }else{
                                unset($this->hearts[array_search($name, $this->hearts)]);
                                $sender->sendMessage("§b[GrapeParticleUI]\n§aDisabled Hearts Particle");
                            }
                            break;
            }
        });
        $form->setTitle("§bGrapeParticlesUI");
        $form->setContent("§bChoose A Particle");
        $form->addButton("§bWaterDrip \n" . $msg1);
        $form->addButton("§bFlame \n" . $msg2);
        $form->addButton("§bHearts \n" . $msg3);
        $form->addButton("§bExit");
        $form->sendToPlayer($player);                  
        return $form;   
    }
}
