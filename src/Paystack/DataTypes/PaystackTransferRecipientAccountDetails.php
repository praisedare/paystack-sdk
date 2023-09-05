<?php

namespace Praise\Paystack\DataTypes;

/**
 * Represents the data contained the 'data.details' attribute
 * of a successful Transfer Recipient creation response.
 */
class PaystackTransferRecipientAccountDetails
{
    public ?string $authorization_code = null;

    public ?string $account_number = null;

    public ?string $account_name = null;

    public string $bank_code;

    public string $bank_name;

    public function __construct(\stdClass $data)
    {
        $props = ['authorization_code', 'account_name',
            'account_number', 'bank_code', 'bank_name'];

        foreach ($props as $prop_name)
            $this->{$prop_name} = @$data->{$prop_name};
    }
}

