<?php

namespace Praise\Paystack\DataTypes\Response;

abstract class PaystackResponse
{
	/**
	 * The status of the action performed
	 */
	public ?bool $status;

	/**
	 * An accompanying message for the status
	 */
	public ?string $message;

	/**
	 * Construct the response object
	 * @param \stdClass $attributes The data to be used in constructing the object is not
	 *                              received as a list of paremeters, but rather as a single
	 *                              \stdClass object because the data is expected to come
	 *                              directly from a Paystack API, and not filled in by a user.
	 */
	public function __construct(\stdClass $attributes)
	{
		foreach (['status', 'message'] as $key)
			$this->{$key} = @$attributes->{$key};
	}

	public function __toString()
	{
		return json_encode($this, JSON_PRETTY_PRINT);
	}
}
