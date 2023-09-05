<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackBankAccountResolutionResponseData;

class PaystackBankAccountResolutionResponse extends PaystackResponse
{
	public PaystackBankAccountResolutionResponseData|null $data;

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		$this->data = new PaystackBankAccountResolutionResponseData($attributes->data);
	}
}

