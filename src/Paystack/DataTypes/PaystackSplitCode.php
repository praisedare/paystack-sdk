<?php

namespace Praise\Paystack\DataTypes;

class PaystackSplitCode
{
	public function __construct(
		public string $code
	)
	{}

	public function data()
	{
		return $this->code;
	}
}
