<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackTransactionVerificationResponseData;

class PaystackTransactionVerificationResponse extends PaystackResponse
{
	public PaystackTransactionVerificationResponseData|null $data;

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		$this->data = new PaystackTransactionVerificationResponseData($attributes->data);
	}
}
