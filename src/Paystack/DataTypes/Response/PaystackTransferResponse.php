<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackBankAccountResolutionResponseData;
use Praise\Paystack\DataTypes\Response\Data\PaystackTransferResponseData;

class PaystackTransferResponse extends PaystackResponse
{
	public PaystackTransferResponseData|null $data;

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		$this->data = new PaystackTransferResponseData($attributes->data);
	}
}


