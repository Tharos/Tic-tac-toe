<?php

namespace WebsiteModule;

use TicTacToe\Settings;

/**
 * @author Vojtěch Kohout
 */
interface IGameControlFactory
{

	/**
	 * @param Settings $settings
	 * @return GameControl
	 */
	function create(Settings $settings);

}
