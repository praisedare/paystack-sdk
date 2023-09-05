<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackTransferRecipientCreationResponseData;

class PaystackTransferRecipientCreationResponse extends PaystackResponse
{
	public PaystackTransferRecipientCreationResponseData |null $data;

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		$this->data = new PaystackTransferRecipientCreationResponseData($attributes->data);
	}
}

