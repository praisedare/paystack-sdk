<?php

namespace Praise\Paystack\DataTypes\Response\Data;

class PaystackPlanCreationResponseData extends PaystackResponseData
{
    public string $name;

    public int $amount;

    public string $interval;

    public string $plan_code;

    public string $currency;
}

