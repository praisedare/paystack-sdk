<?php

namespace Praise\Paystack\DataTypes\Response;

use Praise\Paystack\DataTypes\Response\Data\PaystackPlanCreationResponseData;
use Praise\Paystack\DataTypes\Response\Data\PaystackSubaccountCreationResponseData;

class PaystackPlanCreationResponse extends PaystackResponse
{
    public PaystackPlanCreationResponseData $data;

    public function __construct(\stdClass $attributes)
    {
        parent::__construct($attributes);

        $this->data = new PaystackPlanCreationResponseData($attributes->data);
    }

}

