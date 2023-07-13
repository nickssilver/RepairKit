<?php
namespace App\Billing;

class ManualPaymentGateway implements PaymentGatewayContract
{
    private $biller = null;

    public function __construct($name)
    {
        $this->biller = $name;
    }

    public function charge($validated)
    {
        $validated['payment_info'] = __('Created by') . ' : ' . $this->biller;
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
