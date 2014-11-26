<?php

namespace TicTacToe;

use TicTacToe\Exception\GameOverException;
use TicTacToe\Exception\InvalidTurnException;

/**
 * @author Vojtěch Kohout
 */
class Game
{

	/** @var Settings */
	private $settings;


	/**
	 * @param Settings $settings
	 */
	public function __construct(Settings $settings)
	{
		$this->settings = $settings;
	}

	public function play()
	{
		$this->printWelcome();

		$board = new Board($this->settings);
		$playing = true;

		while ($playing) {
			echo 'Hráč ' . $board->getCurrentPlayer() . ': ';

			$command = rtrim(fgets(STDIN));
			switch ($command) {
				case 'quit':
					$playing = false;
					echo "Naviděnou.\n";
					break;

				case 'new':
					$board = new Board($this->settings);
					break;

				case 'show':
					$this->printBoard($board);
					break;

				default:
					$x = substr($command, 1, 1);
					$y = ord(substr($command, 0, 1)) - ord('a') + 1;
					if (strlen($command) !== 2) {
						echo "Tah ve špatném formátu.\n";
					} else {
						try {
							$board->turn($x, $y);

						} catch (InvalidTurnException $e) {
							echo $e->getMessage() . "\n";

						} catch (GameOverException $e) {
							echo $e->getMessage() . "\n";
							$playing = false;
							$this->printBoard($board);
						}
					}
			}
		}
	}

	private function printWelcome()
	{
		echo "Ahoj v piškvorkách naslepo.\n" .
			"Povolené příkazy jsou:\n" .
			"new - nová hra\n" .
			"quit - konec\n" .
			"show - zobrazení hracího pole\n" .
			"[a-i][0-9] - tah na pole, kde řada je pozice a, b, c, d, e, f, g, h, i. Sloupec je 1 až 9.\n" .
			"Formát zápisu je např. e5.\n";
	}

	/**
	 * @param Board $board
	 */
	private function printBoard(Board $board)
	{
		$boardState = $board->getState();

		array_unshift($boardState, null);
		$boardState = call_user_func_array('array_map', $boardState);

		foreach ($boardState as $line) {
			foreach ($line as $value) {
				echo isset($value) ? "$value " : ". ";
			}
			echo "\n";
		}
	}

}
