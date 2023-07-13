<?php
namespace App\Billing;

class BrantreePaymentGateway implements PaymentGatewayContract
{
    private $token = null;
    private $gateway = null;

    public function __construct($nonce)
    {
        $this->token = $nonce;
        $this->gateway = new \Braintree\Gateway(
            [
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchant_id'),
                'publicKey' => config('services.braintree.public_key'),
                'privateKey' => config('services.braintree.private_key'),
            ]
        );
    }

    public function payDue($order)
    {
        $result = $this->gateway->transaction()->sale(
            [
                'amount' => $order->dueAmount(),
                'paymentMethodNonce' => $this->token,
                'customer' => [
                    'firstName' => $order->name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                ],
                'options' => [
                    'submitForSettlement' => true,
                ],
            ]
        );
        $transaction = $result->transaction;
        return [
            'success' => $result->success,
            'payment_status' => $result->success,
            'payment_info' => $order->payment_info . ' <br/>' . $transaction->paymentInstrumentType,
            'pre_paid' => $order->pre_paid + $order->dueAmount(),
        ];
    }

    public function charge($validated)
    {
        $result = $this->gateway->transaction()->sale(
            [
                'amount' => $validated['total_charges'],
                'paymentMethodNonce' => $this->token,
                'customer' => [
                    'firstName' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                ],
                'options' => [
                    'submitForSettlement' => true,
                ],
            ]
        );
        $transaction = $result->transaction;
        $validated['pre_paid'] = $validated['total_charges'];
        $validated['payment_info'] = $transaction->paymentInstrumentType;
        $validated['payment_status'] = true;

        return [
            'success' => $result->success,
            'data' => $validated,
        ];
    }
}
