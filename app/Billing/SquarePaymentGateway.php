<?php
namespace App\Billing;

use Illuminate\Support\Str;
use Square\Environment;
use Square\Models\CreatePaymentRequest;
use Square\Models\Money;
use Square\SquareClient;

class SquarePaymentGateway implements PaymentGatewayContract
{
    private $card_nonce = null;
    private $location_id = null;
    private $idempotency_key = null;

    public function __construct($square)
    {
        $this->card_nonce = $square;
        $this->location_id = config('services.square.location_id');
        $this->idempotency_key = (string) Str::uuid();
    }

    public function payDue($order)
    {
        $client = new SquareClient([
            'accessToken' => config('services.square.access_token'),
            'environment' => config('services.square.sandbox') ? Environment::SANDBOX : Environment::PRODUCTION,
        ]);
        $amount_money = new Money();
        $amount_money->setAmount(100 * $order->dueAmount());
        $amount_money->setCurrency(config('services.square.currency'));

        $body = new CreatePaymentRequest(
            $this->card_nonce,
            $this->idempotency_key,
            $amount_money
        );

        $body->setAutocomplete(true);
        $body->setLocationId($this->location_id);
        $body->setReferenceId($order->tracking);

        $api_response = $client->getPaymentsApi()->createPayment($body);

        if ($api_response->isSuccess()) {
            return [
                'pre_paid' => $order->pre_paid + $order->dueAmount(),
                'payment_info' => json_encode($api_response->getResult()) . '<br/>' . $order->payment_info,
                'payment_status' => true,
                'success' => true,
            ];
        } else {
            $errors = $api_response->getErrors();
            dd($errors);
        }
    }

    public function charge($validated)
    {
        $client = new SquareClient([
            'accessToken' => config('services.square.access_token'),
            'environment' => config('services.square.sandbox') ? Environment::SANDBOX : Environment::PRODUCTION,
        ]);

        $amount_money = new Money();
        $amount_money->setAmount(100 * $validated['total_charges']);
        $amount_money->setCurrency(config('services.square.currency'));

        $body = new CreatePaymentRequest(
            $this->card_nonce,
            $this->idempotency_key,
            $amount_money
        );

        $body->setAutocomplete(true);
        $body->setLocationId($this->location_id);
        $body->setReferenceId($validated['tracking']);

        $api_response = $client->getPaymentsApi()->createPayment($body);

        if ($api_response->isSuccess()) {
            $validated['pre_paid'] = $validated['total_charges'];
            $validated['payment_info'] = json_encode($api_response->getResult());
            $validated['payment_status'] = true;
            return [
                'success' => $validated['payment_status'],
                'data' => $validated,
            ];
        } else {
            $errors = $api_response->getErrors();
            dd($errors);
        }
    }
}
