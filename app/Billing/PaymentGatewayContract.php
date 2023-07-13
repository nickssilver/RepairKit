<?php
namespace App\Billing;

interface PaymentGatewayContract
{
    public function payDue($order);
    public function charge($validated);
}
