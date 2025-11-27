<?php

return [
    'required' => ':attribute harus diisi.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'unique' => ':attribute sudah terdaftar.',
    'max' => [
        'string' => ':attribute tidak boleh lebih dari :max karakter.',
    ],
    'min' => [
        'string' => ':attribute minimal :min karakter.',
    ],

    'attributes' => [
        'nama' => 'Nama',
        'email' => 'Email',
        'hp' => 'No. HP',
        'password' => 'Password',
    ],
];
