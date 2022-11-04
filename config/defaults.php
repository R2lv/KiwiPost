<?php


return [

    /*
     |--------------------------------------------------------------------------
     | User roles
     |--------------------------------------------------------------------------
     |
     | This option controlles user roles
     |
     */

    'roles' => [
        'PARCEL_ADD'=>1,
        'PARCEL_DELETE'=>2,
        'PARCEL_VIEW_ALL'=>4,
        'PARCEL_CHANGE_STATUS'=>8,
        'PARCEL_MAKE_PAYMENT'=>16,
        'PARCEL_EXPORT'=>32,
        'VIEW_STATISTICS'=>64,
        'ALL'=>128,
        'ARTICLE_ADD'=>256,
        'SEE_USERS'=>512,
    ],


    'parcels'=>[
        'statuses'=>[
            'waiting'=>'Waiting',
            'werehouse'=>'Werehouse',
            'inTransit'=>'In transit',
            'terminal'=>'Terminal',
            'arrived'=>'Arrived',
            'obtained'=>'Obtained',
            'stopped'=>'Stopped'
        ],
        'types' => []
    ],

    'notifications' => [
        'email_verification' => [
            'title_en'=>'Email verificaiton',
            'title_ka'=>'ელ-ფოსტის ვერიფიცირება',
            'text_en'=>'Please verify email to get access all of Kiwipost features',
            'text_ka'=>'გთხოვთ დაადასტუროთ ელ-ფოსტა რათა სრულიად გამოიყენოთ კივი ფოსტის შესაძლებლობები',
            'button_text_en'=>'Resend email verification',
            'button_text_ka'=>'გადაგზავნა  ',
            'button_action'=>'resend_verification_email',
            'button_url'=>null,
            'button_2_text_en'=>'Edit email',
            'button_2_text_ka'=>'ელ. ფოსტის შეცვლა',
            'button_2_action'=>'edit_email_address',
            'button_2_url'=>null,
            'button_close'=>0,
            'type'=>'warning',
            'priority'=>5,
            'status'=>0
        ],
        'mobile_verification' => [
            'title_en'=>'Mobile verificaiton',
            'title_ka'=>'მობ.ნომრის დადასტურება',
            'text_en'=>'Please verify mobile number to be notified about your parcel information',
            'text_ka'=>'გთხოვთ დაადასტუროთ მობ. ნომერი, რათა მიიღოთ თქვენი ამანათების შესახებ ინფორმაცია',
            'button_text_en'=>'Verify',
            'button_text_ka'=>'დადასტურება',
            'button_action'=>'verify_mobile_number',
            'button_url'=>null,
            'button_close'=>0,
            'type'=>'warning',
            'priority'=>5,
            'status'=>0
        ],
        'email_verified' => [
            'title_en'=>'Email is verified',
            'title_ka'=>'ელ-ფოსტა ვერიფიცირებულია',
            'text_en'=>'Congradulations, email is verified, Now you can access all of kiwipost features',
            'text_ka'=>'გილოცავთ, ელ-ფოსტა ვერიფიცირებულია, უკვე შეგიძლიათ გამოიყენოთ კივი ფოსტის ყველა შესაძლებლობა',
            'button_close'=>1,
            'type'=>'success',
            'priority'=>5,
            'status'=>0
        ],
    ],

    'notification_types' => [
        'success','error','warning'
    ],
    'unicard' => [
        'client' =>'OEYxNEU0NUZDRUVBMTY3QTVBMzZERURENEJFQTI1NDM=',
        'privateKey' => '2ZiLmpLEzgm/hcHyedc/4pgImflG2ILj1zIBAGLhFhM='
    ]

];