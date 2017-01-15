<?php
namespace VirtualComplete\Selector\Example\Tests;

use VirtualComplete\Selector\Selector;

class InvalidSelector extends Selector
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
            'credit' => 'VirtualComplete\Selector\Example\Tests\InvalidPaymentMethod'
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
        return null;
    }
}
