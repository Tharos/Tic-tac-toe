<?php

namespace TicTacToe;

use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\InvalidStateException;

/**
 * @author Vojtěch Kohout
 */
class PersistentGame
{

	/** @var SessionSection */
	private $section;


	/**
	 * @param Session $session
	 */
	public function __construct(Session $session)
	{
		$this->section = $session->getSection(self::class);
	}

	/**
	 * @return Board
	 * @throws InvalidStateException
	 */
	public function loadBoard()
	{
		if (!isset($this->section->board)) {
			throw new InvalidStateException('Missing game in session.');
		}

		return unserialize($this->section->board);
	}

	/**
	 * @param Board $board
	 */
	public function persistBoard(Board $board)
	{
		$this->section->board = serialize($board);
	}

	public function lock()
	{
		$this->section->locked = true;
	}

	/**
	 * @return bool
	 */
	public function isLocked()
	{
		return isset($this->section->locked) and $this->section->locked === true;
	}

	/**
	 * @param string $message
	 */
	public function saveMessage($message)
	{
		$this->section->message = (string) $message;
	}

	/**
	 * @return string|null
	 */
	public function getMessage()
	{
		return $this->section->message;
	}

	public function clearSession()
	{
		$this->section->remove();
	}

}
