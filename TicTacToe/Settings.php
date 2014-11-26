<?php

namespace TicTacToe;

use InvalidArgumentException;

/**
 * @author Vojtěch Kohout
 */
class Settings
{

	const MINIMAL_DIMENSIONS = 3;

	/** @var int */
	private $sizeX;

	/** @var int */
	private $sizeY;

	/** @var int */
	private $countToWin;

	/** @var string[] */
	private $players;


	/**
	 * @param int $sizeX
	 * @param int $sizeY
	 * @param int $countToWin
	 * @param string[] $players
	 */
	public function __construct($sizeX, $sizeY, $countToWin, array $players)
	{
		if ($sizeX < self::MINIMAL_DIMENSIONS or $sizeY < self::MINIMAL_DIMENSIONS) {
			throw new InvalidArgumentException('Minimal board dimensions are ' . self::MINIMAL_DIMENSIONS . 'x' . self::MINIMAL_DIMENSIONS);
		}
		if ($countToWin > ($max = max($sizeX, $sizeY))) {
			throw new InvalidArgumentException("Count to win cannot be lower than $max");
		}

		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
		$this->countToWin = $countToWin;
		$this->players = $players;
	}

	/**
	 * @return int
	 */
	public function getSizeX()
	{
		return $this->sizeX;
	}

	/**
	 * @return int
	 */
	public function getSizeY()
	{
		return $this->sizeY;
	}

	/**
	 * @return int
	 */
	public function getCountToWin()
	{
		return $this->countToWin;
	}

	/**
	 * @return string[]
	 */
	public function getPlayers()
	{
		return $this->players;
	}

}
