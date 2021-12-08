<?php
use App\Models\Order;
use App\Util\CartStates;

return [
    'checkout' => [
        'class' => Order::class,
        'graph' => 'checkout',
        'property_path' => 'state',
        'metadata' => [
            'title' => 'Checkout graph'
        ],
        'states' => CartStates::getStates(),

        // list of all possible transitions
        'transitions' => [
            'accept_contract' => [
                'from' => [
                    CartStates::$NEW
                ],
                'to' => CartStates::$CONTRACT_ACCEPTED
            ],
            'deny_contract' => [
                'from' => [
                    CartStates::$NEW
                ],
                'to' => CartStates::$CONTRACT_DENIED
            ],
            'attempt_payment' => [
                'from' => [
                    CartStates::$CONTRACT_ACCEPTED,
                    CartStates::$PAYMENT_FAILED
                ],
                'to' => CartStates::$AWAITING_PAYMENT
            ],
            'successful_payment' => [
                'from' => [
                    CartStates::$AWAITING_PAYMENT,
                    CartStates::$PAYMENT_FAILED
                ],
                'to' => CartStates::$PAID
            ],
            'failed_payment' => [
                'from' => [
                    CartStates::$AWAITING_PAYMENT,
                    CartStates::$PAYMENT_FAILED
                ],
                'to' => CartStates::$PAYMENT_FAILED
            ],
            'send_assets' => [
                'from' => [
                    CartStates::$PAID
                ],
                'to' => CartStates::$ASSETS_SENT
            ],
            'receive_assets' => [
                'from' => [
                    CartStates::$ASSETS_SENT
                ],
                'to' => CartStates::$ASSETS_RECEIVED
            ],
            'complete' => [
                'from' => [
                    CartStates::$ASSETS_RECEIVED
                ],
                'to' => CartStates::$COMPLETE
            ],
            'reject' => [
                'from' => [
                    CartStates::$NEW,
                    CartStates::$CONTRACT_DENIED,
                    CartStates::$CONTRACT_ACCEPTED,
                    CartStates::$PAYMENT_FAILED
                ],
                'to' => CartStates::$REJECTED
            ],
            'cancel' => [
                'from' => [
                    CartStates::$NEW,
                    CartStates::$CONTRACT_DENIED,
                    CartStates::$CONTRACT_ACCEPTED,
                    CartStates::$PAYMENT_FAILED
                ],
                'to' => CartStates::$CANCELLED
            ],
            'refund' => [
                'from' => [
                    CartStates::$COMPLETE,
                    CartStates::$ASSETS_SENT,
                    CartStates::$ASSETS_RECEIVED,
                    CartStates::$PAID
                ],
                'to' => CartStates::$REFUNDED
            ]
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called when testing a transition
            'guard' => [
                'guard_on_submitting' => [
                    // call the callback on a specific transition
                    'on' => 'submit_changes',
                    // will call the method of this class
                    'do' => [
                        'MyClass',
                        'handle'
                    ],
                    // arguments for the callback
                    'args' => [
                        'object'
                    ]
                ],
                'guard_on_approving' => [
                    // call the callback on a specific transition
                    'on' => 'approve',
                    // will check the ability on the gate or the class policy
                    'can' => 'approve'
                ]
            ],

            // will be called before applying a transition
            'before' => [],

            // will be called after applying a transition
            'after' => []
        ]
    ]
];
