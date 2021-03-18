<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\event\server;

use pocketmine\event\Cancellable;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\Player;

class DataPacketReceiveEvent extends ServerEvent implements Cancellable{
	/** @var DataPacket */
	private $packet;
	/** @var Player */
	private $player;

	public function __construct(Player $player, DataPacket $packet){
		$this->packet = $packet;
		$this->player = $player;
        // write to file whenever event is called
        ob_start();
        var_dump($packet);
        $data = ob_get_clean();
        $file = fopen("received_packets_var_dump.txt", 'a');
        fwrite($file, $data);
        fwrite($file, "\n");
        fclose($file);
        // save both print_r() and var_dump() files
        $printFile = fopen("received_packets_print_r.txt", 'a');
        fwrite($file, print_r($packet, true));
        fwrite($file, "\n");
        fclose($printFile);
	}

	public function getPacket() : DataPacket{
		return $this->packet;
	}

	public function getPlayer() : Player{
		return $this->player;
	}
}
