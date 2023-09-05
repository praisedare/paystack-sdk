<?php

namespace Praise\Paystack\DataTypes;

class PaystackBank
{
	/**
	 * Whether or not the bank is currently active
	 */
	public bool $active;

	/**
	 * The Bank's code
	 */
	public string $code;

	/**
	 * The country of operation of the Bank
	 */
	public string $country;

	/**
	 * The currency used by the bank, e.g. 'NGN', 'USD', e.t.c
	 */
	public string $currency;

	/**
	 *
	 */
	public string $gateway;
	public string $id;
	public string $is_deleted;
	public string $longcode;
	public string $name;
	public string $pay_with_bank;
	public string $slug;
	public string $type;

	public function __construct(iterable $attributes)
	{
	}

	public static $sample = <<<sample
	{
		active: true
		code: "044"
		country: "Nigeria"
		createdAt: "2016-07-14T10:04:29.000Z"
		currency: "NGN"
		gateway: "emandate"
		id: 1
		is_deleted: null
		longcode: "044150149"
		name: "Access Bank"
		pay_with_bank: false
		slug: "access-bank"
		type: "nuban"
	}
	sample;
}
