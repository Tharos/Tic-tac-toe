<?php

namespace TicTacToe;

/**
 * @author Vojtěch Kohout
 */
class Player
{

	/** @var string */
	private $signature;


	/**
	 * @param string $signature
	 */
	public function __construct($signature)
	{
		$this->signature = (string) $signature;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getSignature();
	}

	/**
	 * @return string
	 */
	public function getSignature()
	{
		return $this->signature;
	}

}
