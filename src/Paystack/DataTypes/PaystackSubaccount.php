<?php

namespace Praise\Paystack\DataTypes;

class PaystackSubaccount
{
    /**
     * The account code
     */
    public string $subaccount;

    /**
     * @param string $account_code
     */
    public function __construct(
        public string $account_code,
        public float $share,
    )
    {
        $this->subaccount = $account_code;
    }

    /**
     * Returns a representation of the data in the format required by Paystack
     * @return
     */
    public function data()
    {
        return [
            'subaccount' => $this->account_code,
            'share' => round($this->share * 100),
        ];
    }
}
