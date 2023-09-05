<?php

namespace Praise\Paystack;

use Illuminate\Http\Request;
use Praise\Paystack\DataTypes\PaystackBank;
use Praise\Paystack\DataTypes\PaystackDynamicSplit;
use Praise\Paystack\DataTypes\PaystackPlan;
use Praise\Paystack\DataTypes\PaystackSplitCode;
use Praise\Paystack\DataTypes\PaystackTransactionInitializationData;
use Praise\Paystack\DataTypes\PaystackTransferInitializationInfo;
use Praise\Paystack\DataTypes\Response\Data\PaystackPlanCreationResponseData;
use Praise\Paystack\DataTypes\Response\{
    PaystackTransactionInitializationResponse,
    PaystackSubaccountCreationResponse,
    PaystackTransactionVerificationResponse,
    PaystackBankAccountResolutionResponse,
    PaystackPlanCreationResponse,
    PaystackPlanUpdateResponse,
    PaystackPlanDeleteResponse,
    PaystackTransferRecipientCreationResponse,
    PaystackTransferResponse,
};

class PaystackHelper
{
    /**
     * Handles webhooks
     *
     * @param  Request $request
     */
    public function handleWebhook(Request $request)
    {
        $req_str = file_get_contents('php://input');
        $request_hash = hash_hmac('sha512', $req_str, config('paystack.secret_key'));

        if (@$_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] != $request_hash) {
            return response(null, 400);
        }

        $event = $request['event'];
        /**
         * @var array
         */
        $data = $request['data'];

        $this->delegateToEventHandler($event, $data);

        return response(null, 200);
    }

    /**
     * Finds and invokes the appropriate webhook event handler
     *
     * @param string $event The paystack event type
     * @param mixed $data The data relating to the event
     */
    private function delegateToEventHandler(string $event, $data)
    {
        $handler = $this->getEventHandler($event);
        if ($handler)
            (new $handler)->handle($data);
    }

    /**
     * Retrieves the name of the class that handles a particular webhook event.
     *
     * To register webhook event handlers, you simply need to create a class
     * that has the "Pascal-cased name of the webhook event + Handler" under the
     * `App\WebhookHandlers` namespace. For example, the name of the 'charge.success'
     * event would be 'ChargeSuccessHandler'; 'customer.verification_successful',
     * 'CustomerVerificationSuccessfulHandler'; and so on
     *
     * @param string $event The name of the webhook event e.g. 'charge.success'
     * @return string|null
     */
    private function getEventHandler(string $event) : string | null
    {
        $handlerClassName = (function(string $event) {
            return preg_replace_callback('~(?:[._]|^)(\w)~', fn($m) => strtoupper($m[1]), $event) . 'Handler';
        })($event);

        $handlerClassName = "\\App\\WebhookHandlers\\$handlerClassName";

        if (class_exists($handlerClassName))
            return $handlerClassName;

        return null;
    }

    /**
     * Returns a list of banks recognized by Paystack
     *
     * @return PaystackBank[]|null
     */
    public function listBanks() : array | null
    {
        $response = $this->makeRequest(
            url: 'https://api.paystack.co/bank',
            request_type: 'GET',
            data: [
                'currency' => 'NGN',
            ],
        );

        if (! $response) {
            return null;
        }

        return $response->data;
    }

    /**
     * Returns data about a bank account number
     *
     * @param string $account_number The account number
     * @param string $bank_code The bank code of the bank. You can get
     *                          this through the `listBanks` function
     * @return PaystackBankAccountResolutionResponse|null
     */
    public function resolveBankAccount(string $bank_code, string $account_number)
    : ?PaystackBankAccountResolutionResponse
    {
        $response = $this->makeRequest(
            'https://api.paystack.co/bank/resolve',
            data: compact('account_number', 'bank_code')
        );

        if (! $response) {
            return null;
        }

        return new PaystackBankAccountResolutionResponse($response);
    }

    /**
     * Before you can transfer money to an account, you need to create a
     * `transfer recipient`.
     *
     * @param string $name The name of the account
     * @param string $account_number The account number
     * @param string $bank_code
     */
    public function createTransferRecipient(
        string $name, string $account_number, string $bank_code,
    ) : ?PaystackTransferRecipientCreationResponse
    {
        /**
         * The currency type the transactions will be carried out in
         * @var string
         */
        $currency = 'NGN';

        $response = $this->makeRequest(
            url: 'https://api.paystack.co/transferrecipient',
            request_type: 'POST',
            data: compact('name', 'account_number', 'bank_code', 'currency')
        );

        if (! $response) {
            return null;
        }

        return new PaystackTransferRecipientCreationResponse($response);
    }

    /**
     * Make a transfer to a transfer recipient
     *
     * @param PaystackTransferIntitializationInfo $transfer Data about the transfer to be made
     * @param string $purpose An identifier that will help to determine the proper handler
     *                        of the webhook event for the created transfer object
     * @param string $data Data to be supplied to the webhook handler
     */
    public function makeTransfer(PaystackTransferInitializationInfo $transfer, string $purpose, string $data) : ?PaystackTransferResponse
    {
        if (! $transfer->amount) {
            return null;
        }

        $source = 'balance';

        $response = $this->makeRequest(
            'https://api.paystack.co/transfer',
            'POST',
            data: array_merge($transfer->data(), compact('source')),
        );

        if (! $response) {
            return null;
        }

        $response = new PaystackTransferResponse($response);

        return $response;
    }

    /**
     * Creates a subaccount
     *
     * @param string $business_name The business name of the account
     * @param string $bank_code The bank code of the account
     * @param string $account_number The account number
     * @param float $percentage_charge The percentage of the total amount that will go to the subaccount.
     *                                 Be sure to write it in the correct format, e.g. 20% is 0.2
     */
    public function createSubaccount(
        string $business_name,
        string $bank_code,
        string $account_number,
        float $percentage_charge = 0.1
    ) : PaystackSubaccountCreationResponse | null
    {
        $response = $this->makeRequest(
            url: 'https://api.paystack.co/subaccount',
            request_type: 'POST',
            data: compact(
                'business_name',
                'bank_code',
                'account_number',
                'percentage_charge',
            ),
        );

        if (! $response) {
            return null;
        }

        return new PaystackSubaccountCreationResponse($response);
    }

    /**
     * Creates a url for a preconfigured payment. This means that it sets the necessary configurations for
     * a transaction such as the payment formula, how much the customer should be charged,
     * e.t.c, and returns a url that uses the set configurations.
     *
     * *Note*: The last two parameters, `$purpose` and `$data`, are not needed by Paystack,
     * rather they are needed for proper handling of the webhook events or callback that
     * follow a successful transaction.
     *
     * @param PaystackTransactionInitializationData $initializer
     * @param string $purpose The purpose of the transaction. Should preferably be a slug-like
     *                        string that can be used to find the right handler for a
     *                        webhook/callback
     * @param string $data Additional data to be passed to the webhook/callback handler
     * @return PaystackTransactionInitializationResponse
     */
    public function initializeTransaction(PaystackTransactionInitializationData $initializer)
    : PaystackTransactionInitializationResponse | null
    {
        $response = $this->makeRequest(
            url: 'https://api.paystack.co/transaction/initialize',
            request_type: 'POST',
            data: json_encode($initializer->data()),
            headers: [
                'Content-Type: application/json',
            ],
        );

        if (!$response) {
            return null;
        }

        $trx_rsp = new PaystackTransactionInitializationResponse($response);

        return $trx_rsp;
    }

    /**
     * Verifies a transaction
     *
     * @param  string $reference The reference of the transaction
     */
    public function verifyTransaction(string $reference)
    : PaystackTransactionVerificationResponse | null
    {
        $response = $this->makeRequest("https://api.paystack.co/transaction/verify/$reference");

        if (! $response) {
            return null;
        }

        if ($response->status) {
            return new PaystackTransactionVerificationResponse($response);
        } else {
            return false;
        }
    }

    /**
     * Creates a payment plan
     *
     * @param PaystackPlan $plan Contains data that will be used in creating the plan
     */
    public function createPlan(PaystackPlan $plan)
    : ?PaystackPlanCreationResponse
    {
        $response = $this->makeRequest(
            url: 'https://api.paystack.co/plan',
            request_type: 'POST',
            data: $plan->data(),
        );

        if (! $response) {
            return null;
        }

        return new PaystackPlanCreationResponse($response);
    }

    /**
     * Updates a plan
     *
     * @param string $plan_code The code (id) of the plan
     * @param PaystackPlan $plan The data to be updated
     */
    public function updatePlan(string $plan_code, PaystackPlan $plan)
    : ?PaystackPlanUpdateResponse
    {
        $response = $this->makeRequest(
            url: "https://api.paystack.co/plan/$plan_code",
            request_type: 'PUT',
            data: $plan->data(),
        );

        if (!$response) {
            return null;
        }

        return new PaystackPlanUpdateResponse($response);
    }

    /**
     * Deletes a plan
     *
     * @param string $plan_code The code (id) of the plan
     * @param PaystackPlan $plan The data to be updated
     */
    public function deletePlan(string $plan_code)
    : ?PaystackPlanDeleteResponse
    {
        $response = $this->makeRequest(
            url: "https://api.paystack.co/plan/$plan_code",
            request_type: 'DELETE',
        );

        if (!$response) {
            return null;
        }

        return new PaystackPlanDeleteResponse($response);
    }

    /**
     * Makes a request to a paystack endpoint and returns the result
     *
     * @param  string $route        The url of the endpoint
     * @param  string $request_type The request type
     * @param  ?array|string $data          The data to be sent
     * @param  array  $headers      Other additional headers apart from `Authorization` that
     *                              should also be sent
     */
    private function makeRequest(string $url, string $request_type = 'GET', $data = null, array $headers = [])
    {
        $curl = curl_init();

        if (strtoupper($request_type) == 'GET' && $data)
            $url = addUrlQueries(url: $url, queries: $data);
        else if (strtoupper($request_type) == 'POST' && $data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request_type,
            CURLOPT_HTTPHEADER => array_merge([
                'Authorization: Bearer ' . config('paystack.secret_key'),
            ], $headers),
        ]);

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);
        curl_close($curl);

        $err = match(true) {
            !! $err => $err,
            $response && ! $response->status => json_encode($response, JSON_PRETTY_PRINT),
            default => null,
        };

        if ($err) {
            return null;
        }

        return $response;
    }
}
