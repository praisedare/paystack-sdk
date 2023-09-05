<?php

namespace Praise\Paystack\DataTypes\Response\Data;

class PaystackTransferResponseData extends PaystackResponseData
{
    /**
     * The transfer refence
     */
    public string $reference;

    /**
     * The currency used in the transfer
     */
    public string $currency;

    /**
     * The amount transferred. Note: The amount will automatically
     * be converted from atomics into the standard monetary unit, i.e.
     * from kobo to naira or pasewas to cedis, e.t.c.
     */
    public float $amount;

    /**
     * The code representing this particular transfer.
     */
    public string $transfer_code;

    public function __construct(\stdClass $data)
    {
        parent::__construct($data);

        $this->amount /= 100;
    }
}

