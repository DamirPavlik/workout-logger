<?php

return [
    'email' => [
        'label' => 'Email',
        'min_length' => 2,
        'max_length' => 255,
        'required' => true,
        'unique' => false,
    ],
    'password' => [
        'label' => 'Password',
        'min_length' => 7,
        'max_length' => 255,
        'required' => true,
        'unique' => false,
    ],
];