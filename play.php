<?php

use TicTacToe\Game;
use TicTacToe\Settings;

require __DIR__ . '/vendor/autoload.php';

(new Game(
	new Settings(9, 9, 5, ['x', 'o'])
))->play();
