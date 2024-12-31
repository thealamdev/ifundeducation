<?php

return [
    'connect' => [
        'stripe_secret' => env('STRIPE_SECRET', 'sk_test_51HI5BcCKybLLVMsSAFPeM6AX1HSb250L8EiFSAFluSOb1dMkWOF4WRnAhweXdayytuigBDLHbUtjNHUMZvWITo8X00mRHKYvxs'),
        'stripe_key'    => env('STRIPE_KEY', 'pk_test_51HI5BcCKybLLVMsSJ1zKQK22Av94EF1nvgUaj3eHTNBvhx9rgri9NFf5b7rjclMgwipLLhL9AJaxQodevyAywkqC00I6kl866i'),
        'refresh_url'   => 'http://ifundeducation.test/withdrawals',
        'return_url'    => 'http://ifundeducation.test/withdrawals',
        'type'          => 'account_onboarding',
    ],
];