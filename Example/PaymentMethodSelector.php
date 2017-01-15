<?php
namespace VirtualComplete\Selector\Example;

use VirtualComplete\Selector\Selector;

class PaymentMethodSelector extends Selector
{
    /**
     * @return string
     */
    protected function setInterface()
    {
        return 'VirtualComplete\Selector\Example\PaymentMethodInterface';
    }

    /**
     * @return array
     */
    protected function setMappings()
    {
        return [
            'cash' => 'VirtualComplete\Selector\Example\CashPaymentMethod',
            'check' => 'VirtualComplete\Selector\Example\CheckPaymentMethod',
            'credit' => 'VirtualComplete\Selector\Example\CreditPaymentMethod'
        ];
    }

    public function getKey($arguments)
    {
        $user = $this->castToArray($arguments)[0];
        return $user['paymentMethod'];
    }

    /**
     * @param $arguments
     * @return array
     */
    protected function castToArray($arguments)
    {
        if (!isset($arguments[0])) {
            return [$arguments];
        }
        return $arguments;
    }

    /**
     * Use this key as a fallback if a key cannot be retrieved from getKey(), or return null to throw a SelectorException.
     *
     * @return string|null
     */
    protected function defaultKey()
    {
        return 'cash';
    }
}
