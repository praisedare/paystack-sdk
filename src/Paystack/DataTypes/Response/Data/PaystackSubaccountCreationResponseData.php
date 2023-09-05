<?php

namespace Praise\Paystack\DataTypes\Response\Data;

class PaystackSubaccountCreationResponseData extends PaystackResponseData
{
	public string $business_name;

	public string $account_number;

	public float $percentage_charge;

	public string $settlement_bank;

	public string $currency;

	public int $bank;

	public string $subaccount_code;

	public bool $is_verified;

	public bool $active;

	public bool $migrate;

	public int $id;
}
