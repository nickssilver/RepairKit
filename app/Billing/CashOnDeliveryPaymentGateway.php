<?php
namespace App\Billing;

class CashOnDeliveryPaymentGateway implements PaymentGatewayContract
{
    public function charge($validated)
    {
        $validated['payment_info'] = 'COD (cash on delivery)';
        $validated['payment_status'] = false;

        return [
            'success' => true,
            'data' => $validated,
        ];
    }

    public function payDue($order)
    {
        return;
    }
}
