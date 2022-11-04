<?php



return [
    'menu'=>'Menu',
    'active_flag'=>'flag-uk',
    'changeLocale'=>'Language',
    'georgian'=>'Georgian',
    'english'=>'English',
    'ge'=>'GE',
    'en'=>'EN',
    'options'=>'Options',
    'hello'=>'Hi',
    'home'=>'Home',
    'cms'=>'CMS',
    'contactUs'=>'Contact Us',
    'dashboard'=>'Dashboard',
    'faqs'=>'FAQ\'S',
    'terms'=>'Terms and conditions',
    'termsURL'=>'/KIWIPOST-TERMS-EN.pdf',
    'aboutUs'=>'About Us',
    'pricing'=>'Pricing',
    'shops'=>'Shops',
    'news'=>'News',
    'logOut'=>'Log Out',
    'signIn'=>'Sign In',
    'signUp'=>'Sign Up',
    'email_count'=>'Verification attempts expired, please contact support',
    'email_already_verified'=>' qEmail already verified',
    'unauthorised'=>'Unverified user',
    'numberExists'=>'The mobile number has already been taken',
    'wrongNumber'=>'Wrong number',
    'sms_success'=>'Sms was sent successfully',
    'notAccessable'=>'Sms service is not allowed in current country',
    'passResetSuccess'=>'Password changed successfully',
    'permission_denied'=>'Permission denied',
    'points'=>'pts',
    'op_success'=>'Operation success',
    'op_failure'=>'Operation failure, please, try again later',
    'wrong_password'=>'Wrong password',
    'user_not_found'=>'User not found or is not E-mail verified',
    'orders'=>[
        'success'=>'Operation success',
        'tracking_exists'=>'tracking number already exists',
        'weight_problem' => 'please check weight',
        'failure' => 'Order already exists',
        'sms'=>'Tkven miiget amanati did britanetshi, gzavnilis kodia ',
        'csms'=>'. gtxovt droulad daadeklarirot amanati. gmadlobt rom sargeblobt chveni momsaxurebit ',
        'payment'=>[
            'success'=>"Paid successfully",
            'prohibited'=>"Payment is prohibited",
            'already_paid' => "Order is already paid",
            'not_enough_money' => "There is not enough money on your balance",
        ],
    ],
    'payments'=>[
        'failure'=>"Payment failure, please contact your bank",
        'failure_title'=>"Error making payment",
        'success'=>"Payment success",
    ],
    'parcels'=> [
        'statuses'=>[
            'waiting'=>'Waiting',
            'warehouse'=>'Warehouse',
            'inTransit'=>'In transit',
            'terminal'=>'Terminal',
            'arrived'=>'Arrived',
            'obtained'=>'Obtained',
            'stopped'=>'Stopped'
        ],
        'types'=> [
            0 => 'Online',
            1 => 'Personal',
        ]
    ],
    'admin'=>[
        'member'=>"Member since :date ",
        'parcels'=>"Parcels",
        'fails'=>"Fails",
    ],
    'unicard'=>[
        'not_exists'=>'Unicard with card number does not exists',
        'already_rewarded'=>'Card has already been rewarded, please use different card',
        'already_exists'=>'Unicard is already registered on other account',
        'paid_success'=>'Your parcel has been paid successfully',
        'nemop'=>'Not enough points to make transaction or already paid',
        'pwpcu'=>'problem with provider, connect Unicard',
        'nua'=>'no Unicard added, please add it in user parameters',
        'sms'=>'You will get SMS validation code from Unicard, please enter it to finish transaction',
    ],
    'fb-messages'=>[
        'welcome'=>"Hi! How can we help you?"
    ]
];