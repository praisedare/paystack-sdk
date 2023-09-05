<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackTransactionInitializationResponseData;

class PaystackTransactionInitializationResponse extends PaystackResponse
{
	public PaystackTransactionInitializationResponseData|null $data;

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		if (property_exists($attributes, 'data'))
			$this->data = new PaystackTransactionInitializationResponseData($attributes->data);
	}
}
