<?php

namespace Praise\Paystack\DataTypes\Response\Data;

class PaystackBankAccountResolutionResponseData extends PaystackResponseData
{
    /**
     * The account's number
     */
    public string $account_number;

    /**
     * The name of the account
     */
    public string $account_name;
}

