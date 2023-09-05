<?php

namespace Praise\Paystack\DataTypes;

use Exception;

class PaystackPlan
{
    /**
     * Represents the data that is used to create a Paystack Plan.
     *
     * @param string $name The name of the plan e.g. 'Monthly Subscription'
     * @param 'daily'|'weekly'|'monthly'|'biannually'|'annually' $interval How frequently the client will be charged
     * @param int $amount The amount of money to be collected in its simplest unit (e.g. kobo)
     */
    public function __construct(
        public string $name,
        public string $interval,
        public int $amount,
    )
    {
        if (!in_array($this->interval, getEnumOptions('paystack_plan_intervals')))
            throw new Exception("Invalid Paystack Plan Interval [$this->interval]");
    }

    public function data()
    {
        $field_names = ['name','interval','amount'];

        $data = [];

        foreach ($field_names as $name)
            $data[$name] = $this->{$name};

        return $data;
    }
}

