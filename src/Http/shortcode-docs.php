<?php
return [
    [
        'section' => 'Email Groups',
        'functions' => [
            [
                'title' => 'Email Groups',
                'des' => 'This function provides all Email Groups According to their types',
                'params' => 'core,custom,plugin',
                'return' => 'Email Groups Listing',
                'code_snap' => 'BBEmailGroups($type)'
            ],
            [
                'title' => 'Email Group',
                'des' => 'This function provides Email Group details',
                'params' => 'id of Email Group',
                'return' => 'Email Group Details',
                'code_snap' => 'BBEmailGroup($id)'
            ]
        ]
    ],
    [
        'section' => 'Language'
    ],
    [
        'section' => 'Back End Settings',
        'functions' => [
            [
                'title' => 'Back End Settings',
                'des' => 'This function provides all backend settings provided by admin',
                'params' => 'NONE',
                'return' => 'all backend settings ',
                'code_snap' => 'BBBkSettings()'
            ]
        ]
    ],
    [
        'section' => 'System',
        'functions' => [
            [
                'title' => 'System Settings',
                'des' => 'This function provides all system settings provided by admin',
                'params' => 'NONE',
                'return' => 'all system settings ',
                'code_snap' => 'BBSysSettings()'
            ]
        ]
    ]
];