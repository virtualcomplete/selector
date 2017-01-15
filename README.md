# Selector

This is an abstract class that allows you to easily implement the provided selector pattern.

Requirements: PHP >5.4.0

## What is the selector pattern?

This selector pattern provides an easy way to deal with polymorphism at the user, or run-time, level.  What does that mean?  Well, if you code to an interface, you should already be familiar with polymorphism.  It allows you to plug in different services using the same interface.  Many frameworks handle the dependency injection of these services by what you bind on an application level.  However, what if you have multiple services that can be applicable based on user settings?  That is where this pattern will come in handy.  See the payment method example below.

# Usage

Just extend the Selector class and fill in the abstract methods as documented.  getKey() should return one of the keys in your setMappings() array based on what arguments your application passes to it.

# Example

```php
class PaymentMethodSelector extends Selector
{
    protected function setInterface()
    {
        return 'VirtualComplete\Selector\Example\PaymentMethodInterface';
        // Easier on PHP >= 5.5
        // return PaymentMethodInterface::class;
    }

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
        $user = $arguments[0];
        return $user['paymentMethod'];
    }

    protected function defaultKey()
    {
        return 'cash';
    }
}

```

You'd then retrieve one of the classes by passing your $user data.

```php
$user['paymentMethod'] = 'credit';
$method = $selector->selectFrom($user); // Returns CreditPaymentMethod instance
```

Use dependency injection with your selector for the best results.