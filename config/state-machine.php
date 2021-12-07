<?php

use App\Models\Order;

return [
    'checkout' => [
        'class' => Order::class,
        'graph' => 'checkout',
        'property_path' => 'state',
        'metadata' => [
            'title' => 'Checkout graph',
        ],
        'states' => [
            'new',
            'contract_accepted',
            'contract_denied',
            'awaiting_payment',
            'paid',
            'payment_failed',
            'assets_sent',
            'assets_received',
            'complete',
            'rejected'
        ],

        // list of all possible transitions
        'transitions' => [
            'accept_contract' => [
                'from' => ['new'],
                'to' => 'contract_accepted',
            ],
            'deny_contract' => [
                'from' => ['new'],
                'to' => 'contract_denied',
            ],
            'attempt_payment' => [
                'from' =>  ['contract_accepted', 'payment_failed'],
                'to' => 'awaiting_payment',
            ],
            'successful_payment' => [
                'from' =>  ['awaiting_payment', 'payment_failed'],
                'to' => 'paid',
            ],
            'failed_payment' => [
                'from' =>  ['awaiting_payment', 'payment_failed'],
                'to' => 'payment_failed',
            ],
            'send_assets' => [
                'from' =>  ['paid'],
                'to' => 'assets_sent',
            ],
            'receive_assets' => [
                'from' =>  ['assets_sent'],
                'to' => 'assets_received',
            ],
            'complete' => [
                'from' =>  ['assets_received'],
                'to' => 'complete',
            ],
            'reject' => [
                'from' =>  ['new', 'contract_denied', 'payment_failed'],
                'to' => 'rejected',
            ],
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called when testing a transition
            'guard' => [
                'guard_on_submitting' => [
                    // call the callback on a specific transition
                    'on' => 'submit_changes',
                    // will call the method of this class
                    'do' => ['MyClass', 'handle'],
                    // arguments for the callback
                    'args' => ['object'],
                ],
                'guard_on_approving' => [
                    // call the callback on a specific transition
                    'on' => 'approve',
                    // will check the ability on the gate or the class policy
                    'can' => 'approve',
                ],
            ],

            // will be called before applying a transition
            'before' => [],

            // will be called after applying a transition
            'after' => [],
        ],
    ],
];
