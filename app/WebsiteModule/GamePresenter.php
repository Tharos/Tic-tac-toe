<?php

namespace WebsiteModule;

use Nette\Application\UI\Presenter;
use TicTacToe\Settings;

/**
 * @author Vojtěch Kohout
 */
class GamePresenter extends Presenter
{

	/**
	 * @var IGameControlFactory
	 * @inject
	 */
	public $gameControlFactory;


	/**
	 * @return GameControl
	 */
	protected function createComponentGame()
	{
		return $this->gameControlFactory->create(
			new Settings(9, 9, 5, ['x', 'o'])
		);
	}

}
