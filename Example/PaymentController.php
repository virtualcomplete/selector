<?php
namespace VirtualComplete\Selector\Example;

class PaymentController
{
    /**
     * @var PaymentMethodInterface
     */
    protected $method;

    /**
     * Not practical, but a way to show how the key can be selected on the user level
     *
     * @var array
     */
    protected $user = [
        'paymentMethod' => 'credit',
    ];

    function __construct(PaymentMethodSelector $selector)
    {
        $this->method = $selector->selectFrom($this->user);
    }

    function post()
    {
        $this->method->acceptPayment($_POST['amount']);
    }
}
