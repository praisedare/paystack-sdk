<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackTransferResponseData;

class PaystackBulkTransferResponse extends PaystackResponse
{
	/**
	 * @var PaystackTransferResponse[]
	 */
	public array $data = [];

	public function __construct(\stdClass $attributes)
	{
		parent::__construct($attributes);

		foreach ($attributes->data as $transfer_data)
			array_push($this->data, new PaystackTransferResponseData($transfer_data));
	}
}
