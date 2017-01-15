<?php
namespace VirtualComplete\Selector\Example;

interface PaymentMethodInterface
{
    public function acceptPayment($amount);
}