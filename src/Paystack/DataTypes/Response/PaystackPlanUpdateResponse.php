<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackPlanCreationResponseData;
use Praise\Paystack\DataTypes\Response\Data\PaystackSubaccountCreationResponseData;

class PaystackPlanUpdateResponse extends PaystackResponse
{
    public function __construct(\stdClass $attributes)
    {
        parent::__construct($attributes);
    }
}

