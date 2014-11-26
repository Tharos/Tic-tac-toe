<?php

namespace TicTacToe;

use InvalidArgumentException;

/**
 * @author Vojtěch Kohout
 */
class Players
{

	const MINIMAL_PLAYERS_COUNT = 2;

	/** @var string[] */
	private $players = [];


	/**
	 * @param string[] $players
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $players)
	{
		foreach ($players as $player) {
			$this->registerPlayer($player);
		}
		if (count($players) < self::MINIMAL_PLAYERS_COUNT) {
			throw new InvalidArgumentException('At least ' . self::MINIMAL_PLAYERS_COUNT . ' must participate the game.');
		}
	}

	/**
	 * @return string
	 */
	public function getCurrentPlayer()
	{
		return current($this->players);
	}

	public function togglePlayers()
	{
		if (next($this->players) === false) {
			reset($this->players);
		}
	}

	/**
	 * @param string $player
	 * @throws InvalidArgumentException
	 */
	private function registerPlayer($player)
	{
		$player = (string) $player;

		if (in_array($player, $this->players, true)) {
			throw new InvalidArgumentException("Player '$player' already exists.'");
		}

		$this->players[] = $player;
	}

}
