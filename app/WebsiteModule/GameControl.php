<?php

namespace WebsiteModule;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\InvalidStateException;
use TicTacToe\Board;
use TicTacToe\Exception\GameOverException;
use TicTacToe\Exception\InvalidTurnException;
use TicTacToe\PersistentGame;
use TicTacToe\Settings;

/**
 * @author Vojtěch Kohout
 */
class GameControl extends Control
{

	/**
	 * @var bool
	 * @persistent
	 */
	public $showBoard = false;

	/** @var Settings */
	private $settings;

	/** @var PersistentGame */
	private $persistentGame;

	/** @var Board */
	private $board;


	/**
	 * @param Settings $settings
	 * @param PersistentGame $persistentGame
	 */
	public function __construct(Settings $settings, PersistentGame $persistentGame)
	{
		$this->settings = $settings;
		$this->persistentGame = $persistentGame;

		try {
			$this->board = $this->persistentGame->loadBoard();

		} catch (InvalidStateException $e) {
			$this->board = $this->createBoard();
		}
	}

	public function handleToggleBoard()
	{
		$this->showBoard = !$this->showBoard;
		$this->redirect('this');
	}

	public function handleRestart()
	{
		$this->createBoard();
		$this->redirect('this');
	}

	public function render()
	{
		$this->template->message = $this->persistentGame->getMessage();
		$this->template->isLocked = $this->persistentGame->isLocked();
		$this->template->shouldBoardBePrinted = $shouldBoardBePrinted = ($this->showBoard or $this->persistentGame->isLocked());
		$this->template->currentPlayer = $this->board->getCurrentPlayer();

		if ($shouldBoardBePrinted) {
			$this->template->board = $this->printBoard($this->board);
		}

		$this->template->render(__DIR__ . '/templates/gameControl.latte');
	}

	/**
	 * @return Form
	 */
	protected function createComponentTurnForm()
	{
		$form = new Form;

		$form->addText('position')
			->setRequired('Zadejte prosím pozici');

		$form->addSubmit('submit', 'Hrát');

		$form->onSuccess[] = function (Form $form) {
			$position = $form['position']->getValue();

			$x = substr($position, 1, 1);
			$y = ord(substr($position, 0, 1)) - ord('a') + 1;

			if (strlen($position) !== 2) {
				$form->addError('Tah ve špatném formátu');

			} else {
				try {
					$this->board->turn($x, $y);

				} catch (InvalidTurnException $e) {
					$form->addError($e->getMessage());

				} catch (GameOverException $e) {
					$this->persistentGame->lock();
					$this->persistentGame->saveMessage($e->getMessage());
				}

				if (!$form->hasErrors()) {
					$this->persistentGame->persistBoard($this->board);
					$this->redirect('this');
				}
			}
		};

		return $form;
	}

	/**
	 * @return Board
	 */
	private function createBoard()
	{
		$board = new Board($this->settings);

		$this->persistentGame->clearSession();
		$this->persistentGame->persistBoard($board);

		return $board;
	}

	/**
	 * @param Board $board
	 * @return string
	 */
	private function printBoard(Board $board)
	{
		$boardState = $board->getState();

		array_unshift($boardState, null);
		$boardState = call_user_func_array('array_map', $boardState);

		$output = '';
		foreach ($boardState as $line) {
			foreach ($line as $value) {
				$output .= isset($value) ? "$value " : ". ";
			}
			$output .= "\n";
		}

		return $output;
	}

}
