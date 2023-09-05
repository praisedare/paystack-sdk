<?php

namespace Praise\Paystack\DataTypes;

use Exception;

class PaystackDynamicSplit
{
    public array $subaccounts = [];

    /**
     * @param  string $type How the amount will be shared. `flat` for fixed amounts, or `percentage` for percentages
     * @param string $bearer_type The account that will bear the cost of the transaction (Paystack's transaction fee).
     * @param ?string $bearer_subaccount	The code of the subaccount that will bear the cost of the transaction. (Only required if the
     *                                      `bearer_type` is `subaccount`)
     * @param PaystackSubaccount[] $subaccounts The subaccounts to split the payment between
     * @var
     */
	public function __construct(
        public string $type,
        public string $bearer_type,
        public ?string $bearer_subaccount = null,
        array $subaccounts = [],
	)
    {
    	if ($this->bearer_type == 'subaccount' && ! $bearer_subaccount)
    		throw new Exception('A bearer_subaccount must be provided when the using bearer type \'subaccount\'');

        foreach ($subaccounts as $subaccount)
            $this->addSubaccount($subaccount);
    }

    /**
     * Adds a subaccount to the list of subaccounts for this class instance.
     * @param PaystackSubaccount $subaccount
     * @return bool Indicates the status of the action
     */
    public function addSubaccount(PaystackSubaccount $subaccount)
    {
        if (in_array($subaccount, $this->subaccounts))
            return false;

        array_push($this->subaccounts, $subaccount);

        return true;
    }

    /**
     * Returns an array containing the data of this class instance
     * @return array
     */
    public function data() : array
    {
        return [
            'type' => $this->type,
            'bearer_type' => $this->bearer_type,
            'bearer_subaccount' => $this->bearer_subaccount,
            'subaccounts' => array_map(fn ($s) => $s->data(), $this->subaccounts),
        ];
    }
}
