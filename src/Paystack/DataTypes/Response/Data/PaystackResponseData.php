<?php

namespace Praise\Paystack\DataTypes\Response\Data;

/**
 * Represents the `data` attribute of a Paystack response.
 * Note: Only the most important - rather than all - the information within the `data` attribute will be
 * represented by the class.
 */
abstract class PaystackResponseData
{
	public function __construct(\stdClass $attributes)
	{
		foreach ($attributes as $key => $value)
			$this->{$key} = $value;
	}
}
