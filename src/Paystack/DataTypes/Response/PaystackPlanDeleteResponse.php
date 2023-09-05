<?php

namespace Praise\Paystack\DataTypes\Response;

class PaystackPlanDeleteResponse extends PaystackResponse
{
    public function __construct(\stdClass $attributes)
    {
        parent::__construct($attributes);
    }
}