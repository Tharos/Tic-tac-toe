<?php

namespace TicTacToe;

use InvalidArgumentException;

/**
 * @author Vojtěch Kohout
 */
class Players
{

	const MINIMAL_PLAYERS_COUNT = 2;

	/** @var Player[] */
	private $players = [];


	/**
	 * @param string[] $playerSignatures
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $playerSignatures)
	{
		foreach ($playerSignatures as $playerSignature) {
			$this->registerPlayer($playerSignature);
		}
		if (count($this->players) < self::MINIMAL_PLAYERS_COUNT) {
			throw new InvalidArgumentException('At least ' . self::MINIMAL_PLAYERS_COUNT . ' must participate the game.');
		}

		reset($this->players);
	}

	/**
	 * @return Player
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
	 * @param string $playerSignature
	 * @throws InvalidArgumentException
	 */
	private function registerPlayer($playerSignature)
	{
		foreach ($this->players as $registeredPlayer) {
			if ($registeredPlayer->getSignature() === $playerSignature) {
				throw new InvalidArgumentException("Player with signature '$playerSignature' already exists.'");
			}
		}

		$this->players[] = new Player($playerSignature);
	}

}
