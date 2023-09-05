<?php

namespace Praise\Paystack\DataTypes;

class PaystackTransferInitializationInfo
{
	/**
	 * @param float $amount
     * The amount to be transferred.
     *
     * **NOTE** Supply the amount in its standard form, (e.g. 150.23). The function
     * will handle all conversions to the rudimentary format.
     *
	 * @param string $recipient
	 * The recipient code of the receiver
	 *
     * @param string $reason
	 * The reason for the transfer
	 */
	public function __construct(
		public float $amount,
		public string $recipient,
		public string $reason = 'Payment',
	)
	{}

	/**
	 * Returns the data of this object in a format consumable by a Paystack API
	 */
	public function data()
	{
		return [
			'amount' => $this->amount * 100,
			'recipient' => $this->recipient,
			'reason' => $this->reason,
		];
	}
}
