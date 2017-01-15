<?php

class SelectorTest extends PHPUnit_Framework_TestCase
{
    public function test_that_selector_can_be_instantiated()
    {
        $selector = new \VirtualComplete\Selector\Example\PaymentMethodSelector();
        $this->assertInstanceOf('VirtualComplete\Selector\Example\PaymentMethodSelector', $selector);
    }

    public function test_can_receive_credit_instance()
    {
        $selector = new \VirtualComplete\Selector\Example\PaymentMethodSelector();
        $user['paymentMethod'] = 'credit';
        $method = $selector->selectFrom($user);
        $this->assertInstanceOf('VirtualComplete\Selector\Example\CreditPaymentMethod', $method);
    }

    public function test_case_insensitive_mapping()
    {
        $selector = new \VirtualComplete\Selector\Example\PaymentMethodSelector();
        $selector->caseSensitiveMappings = false;
        $user['paymentMethod'] = 'crEdIt';
        $method = $selector->selectFrom($user);
        $this->assertInstanceOf('VirtualComplete\Selector\Example\CreditPaymentMethod', $method);
    }

    public function test_invalid_mapping_throws_exception()
    {
        if (method_exists($this, 'setExpectedException')) {
            $this->setExpectedException('VirtualComplete\Selector\SelectorException');
        } else {
            $this->expectException('VirtualComplete\Selector\SelectorException');
        }
        $selector = new \VirtualComplete\Selector\Example\Tests\InvalidSelector();
        $user['paymentMethod'] = 'credit';
        $selector->selectFrom($user);
    }

    public function test_invalid_key_returns_default_key()
    {
        $selector = new \VirtualComplete\Selector\Example\PaymentMethodSelector();
        $user['paymentMethod'] = '';
        $method = $selector->selectFrom($user);
        $this->assertInstanceOf('VirtualComplete\Selector\Example\CashPaymentMethod', $method);
    }

}
