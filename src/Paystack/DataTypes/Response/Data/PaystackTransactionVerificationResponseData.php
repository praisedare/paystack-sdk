<?php

namespace Praise\Paystack\DataTypes\Response\Data;

class PaystackTransactionVerificationResponseData extends PaystackResponseData
{
	/**
	 * The id of the transaction
	 */
    public int $id;

    /**
     * The 'environment' the transaction was made in. Can be either
     * `test` or `live`
     */
    public string $domain;

    /**
     * The status of the transaction. Can be either `success` or `fail`
     */
    public string $status;

    /**
     * The reference of the transaction
     */
    public string $reference;

    /**
     * The amount transacted in its lowest currency format. i.e. amount
     * is given in kobo, cents, pasewas e.t.c.
     */
    public int $amount;

    /**
     * The payment method e.g. `card`
     */
    public string $channel;

    /**
     * The currency used for the transaction, e.g. 'NGN'
     */
    public string $currency;

    /**
     * The ip address of the host that created the transaction.
     */
    public string $ip_address;
}
