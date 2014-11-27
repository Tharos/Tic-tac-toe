<?php

namespace WebsiteModule;

use Nette\Application\UI\Control;

/**
 * @author Vojtěch Kohout
 */
class GameControl extends Control
{

	public function render()
	{
		$this->template->render(__DIR__ . '/templates/gameControl.latte');
	}

}
