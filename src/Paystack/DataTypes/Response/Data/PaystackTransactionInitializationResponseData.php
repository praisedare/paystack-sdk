<?php

namespace Praise\Paystack\DataTypes\Response\Data;

class PaystackTransactionInitializationResponseData extends PaystackResponseData
{
	/**
	 * The url that will be used to carry out the transaction
	 */
	public string $authorization_url;

	/**
	 * The unique identifier that determines the transaction configurations to be used.
	 * (It will already be contained in the `authorization_url`)
	 */
	public string $access_code;

	/**
	 * A reference to the transaction (used to prevent duplicate payments)
	 */
	public string $reference;
}
