<?php

namespace Praise\Paystack\DataTypes\Response\Data;

use Praise\Paystack\DataTypes\PaystackTransferRecipientAccountDetails;

class PaystackTransferRecipientCreationResponseData extends PaystackResponseData
{
    /**
     * The 'environment' the resource was created in. Can be either
     * `test` or `live`
     */
    public string $domain;

    /**
     * The currency used in the transfer
     */
    public string $currency;

    /**
     * The name given to the transfer recipient
     */
    public string $name;

    /**
     * The code that will be used to make transfers to the transfer recipient
     */
    public string $recipient_code;

    /**
     * Details about the account the transfer will be made to
     */
    public PaystackTransferRecipientAccountDetails $details;

    public function __construct(\stdClass $attributes)
    {
        $this->details = new PaystackTransferRecipientAccountDetails($attributes->details);
        unset($attributes->details);
        parent::__construct($attributes);
    }
}
