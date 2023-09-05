<?php

namespace Praise\Paystack\DataTypes;

use Illuminate\Support\Facades\Storage;

/**
 * Represents the data required to initialize a Paystack transaction
 */
class PaystackTransactionInitializationData
{
	/**
	 * Contains the data required by a Paystack Transaction Initialize api endpoint
     * @param  string $email The email of the customer who will be charged
     * @param  float $amount The amount of money to be transacted with in its standard form,
     *                       i.e. just the amount, not the amount multiplied by 100. The class
     *                       will handle all conversions automatically.
     * @param  PaystackDynamicSplit|PaystackSplitCode|null $split The split mechanism to use. If `null`,
     *                                                            means no split.
	 */
    public function __construct(
    	public string $email,
    	public float $amount,
    	public PaystackDynamicSplit|PaystackSplitCode|null $split = null,
        public string $callback_url = '',
        public ?array $metadata = null,
    )
    {}

    public function data()
    {
        $data = [];
        $data['email'] = $this->email;
        $data['amount'] = round($this->amount * 100);
        $data['callback_url'] = $this->callback_url;
        $data['metadata'] = $this->metadata;

        $split = $this->split;

        # Determine split type
        $split_key = match (true) {
            $split instanceof PaystackDynamicSplit  => 'split',
            $split instanceof PaystackSplitCode     => 'split_code',
            ! $split                                => '',
        };

        if ($split_key)
            $data[$split_key] = $split->data();

        return $data;
    }
}
