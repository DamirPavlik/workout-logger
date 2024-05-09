<?php

return [
    'username' => [
        'label' => 'Username',
        'min_length' => 2,
        'max_length' => 255,
        'required' => true,
        'unique' => false,
    ],
    'email' => [
        'label' => 'Email',
        'min_length' => 2,
        'max_length' => 255,
        'required' => true,
        'unique' => true,
    ],
    'password' => [
        'label' => 'Password',
        'min_length' => 7,
        'max_length' => 255,
        'required' => true,
        'unique' => false,
    ],
    'confirm_password' => [
        'label' => 'Confirm Password',
        'required' => true,
        'unique' => false,
    ]
];