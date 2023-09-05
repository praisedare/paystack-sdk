<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackSubaccountCreationResponseData;

class PaystackSubaccountCreationResponse extends PaystackResponse
{
	public PaystackSubaccountCreationResponseData|null $data;

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		$this->data = new PaystackSubaccountCreationResponseData($attributes->data);
	}
}
