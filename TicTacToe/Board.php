<?php

namespace TicTacToe;

use TicTacToe\Exception\GameOverException;
use TicTacToe\Exception\InvalidTurnException;

/**
 * @author Vojtěch Kohout
 */
class Board
{

	/** @var Players */
	private $players;

	/** @var array */
	private $matrix;

	/** @var int */
	private $countToWin;

	/** @var int */
	private $remainingTurns;


	/**
	 * @param Settings $settings
	 */
	public function __construct(Settings $settings)
	{
		$this->matrix = array_fill(1, $sizeX = $settings->getSizeX(), array_fill(1, $sizeY = $settings->getSizeY(), null));
		$this->countToWin = $settings->getCountToWin();
		$this->remainingTurns = $sizeX * $sizeY;

		$this->players = new Players($settings->getPlayers());
	}

	/**
	 * @return string
	 */
	public function getCurrentPlayer()
	{
		return $this->players->getCurrentPlayer();
	}

	/**
	 * @param int $x
	 * @param int $y
	 * @throws GameOverException
	 * @throws InvalidTurnException
	 */
	public function turn($x, $y)
	{
		if (!array_key_exists($x, $this->matrix) or !array_key_exists($y, $this->matrix[$x])) {
			throw new InvalidTurnException('Takové pole neexistuje, hraj znovu.');
		}

		if (isset($this->matrix[$x][$y])) {
			throw new InvalidTurnException('Pole je zabráno, hraj znovu.');
		}

		$this->matrix[$x][$y] = $currentPlayer = $this->players->getCurrentPlayer();

		if ($this->isWinningTurn($x, $y)) {
			throw new GameOverException("VÝHRA! Gratulace hráči $currentPlayer.");
		}

		$this->remainingTurns--;
		if ($this->remainingTurns === 0) {
			throw new GameOverException('Remíza, hrací pole zaplněno.');
		}

		$this->players->togglePlayers();
	}

	/**
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	private function isWinningTurn($x, $y)
	{
		if (!isset($this->matrix[$x][$y])) {
			return false;
		}

		$player = $this->matrix[$x][$y];

		$isWinningDirection = function ($x, $y, $dx, $dy) use ($player) {
			for ($i = 1; $i < $this->countToWin; $i++) {
				$x2 = $x - $i * $dx;
				$y2 = $y - $i * $dy;
				if (!isset($this->matrix[$x2][$y2]) or $this->matrix[$x2][$y2] !== $player) {
					break;
				}
			}

			for ($j = 1; $j < $this->countToWin; $j++) {
				$x2 = $x + $j * $dx;
				$y2 = $y + $j * $dy;
				if (!isset($this->matrix[$x2][$y2]) or $this->matrix[$x2][$y2] !== $player) {
					return ($i + $j - 1 >= $this->countToWin);
				}
			}

			return true;
		};

		$winning = false;
		foreach ([[1, 0], [0, 1], [1, 1], [1, -1]] as $vector) {
			$winning |= $isWinningDirection($x, $y, $vector[0], $vector[1]);
		}

		return $winning;
	}

}
