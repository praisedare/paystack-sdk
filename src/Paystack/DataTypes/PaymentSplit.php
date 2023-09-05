<?php

namespace App\DataTypes;

class PaymentSplit
{
	/**
	 * The amount reserved for the app owner
	 */
	public float $master;

	/**
	 * The amount reserved for the developers
	 */
	public float $developer;

	/**
	 * The amount reserved for the main recipient e.g. shop owner
	 */
	public float $main;

	/**
	 * The total amount to be split
	 */
	public float $total;

	public function __construct(iterable $data)
	{
		foreach ($data as $key => $value) {
			$this->{$key} = $value;
		}
		$this->total = $this->master + $this->developer + $this->main;
	}
}
