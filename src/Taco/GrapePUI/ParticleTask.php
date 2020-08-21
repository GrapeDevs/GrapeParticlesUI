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
namespace Taco\GrapePUI;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
class ParticleTask extends Task {
    public function __construct($plugin) {
		$this->plugin = $plugin;
	}
    public function onRun(int $tick) {
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $name = $player->getName();
            $x = $player->getX();
			$y = $player->getY();
			$z = $player->getZ();
            if (in_array($name, $this->plugin->waterdrip)) {
                $center = new Vector3($x, $y, $z);
				for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20) {
				    $x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$y = $center->y;
					$level->addParticle(new WaterDripParticle(new Vector3($x, $y + 1.5, $z))); 
				}
            }
            if (in_array($name, $this->plugin->flame)) {
                $center = new Vector3($x, $y, $z);
				for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20) {
				    $x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$y = $center->y;
					$level->addParticle(new FlameParticle(new Vector3($x, $y + 1.5, $z))); 
				}
            }
            if (in_array($name, $this->plugin->hearts)) {
                $center = new Vector3($x, $y, $z);
				for($yaw = 0; $yaw <= 10; $yaw += (M_PI * 2) / 20) {
				    $x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$y = $center->y;
					$level->addParticle(new HeartParticle(new Vector3($x, $y + 1.5, $z))); 
				}
			}
        }
    }
}
