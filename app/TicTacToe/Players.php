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

	/** @var Player */
	private $currentPlayer;


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

		$this->currentPlayer = reset($this->players);
	}

	/**
	 * @return Player
	 */
	public function getCurrentPlayer()
	{
		return $this->currentPlayer;
	}

	public function togglePlayers()
	{
		$key = array_search($this->currentPlayer, $this->players, true);
		$this->currentPlayer = isset($this->players[$nextKey = $key + 1]) ? $this->players[$nextKey] : reset($this->players);
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
