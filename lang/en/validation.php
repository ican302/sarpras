<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':Attribute harus diterima',
    'accepted_if' => ':Attribute harus diterima ketika :other adalah :value',
    'active_url' => ':Attribute harus merupakan URL yang valid',
    'after' => ':Attribute harus berupa tanggal setelah :date',
    'after_or_equal' => ':Attribute harus berupa tanggal setelah atau sama dengan :date',
    'alpha' => ':Attribute hanya boleh berisi huruf',
    'alpha_dash' => ':Attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah',
    'alpha_num' => ':Attribute hanya boleh berisi huruf dan angka',
    'array' => ':Attribute harus berupa array',
    'ascii' => ':Attribute hanya boleh berisi karakter dan simbol alfanumerik satu-byte',
    'before' => ':Attribute harus berupa tanggal sebelum :date',
    'before_or_equal' => ':Attribute harus berupa tanggal sebelum atau sama dengan :date',
    'between' => [
        'array' => ':Attribute harus memiliki antara :min dan :max item',
        'file' => ':Attribute harus antara :min dan :max kilobyte',
        'numeric' => ':Attribute harus antara :min dan :max',
        'string' => ':Attribute harus antara :min dan :max karakter',
    ],
    'boolean' => ':Attribute harus bernilai benar atau salah',
    'confirmed' => 'Konfirmasi :Attribute tidak cocok',
    'current_password' => 'Kata sandi tidak benar',
    'date' => ':Attribute harus berupa tanggal yang valid',
    'date_equals' => ':Attribute harus berupa tanggal yang sama dengan :date',
    'date_format' => ':Attribute harus sesuai dengan format :format',
    'decimal' => ':Attribute harus memiliki :decimal tempat desimal',
    'declined' => ':Attribute harus ditolak',
    'declined_if' => ':Attribute harus ditolak ketika :other adalah :value',
    'different' => ':Attribute dan :other harus berbeda',
    'digits' => ':Attribute harus terdiri dari :digits digit',
    'digits_between' => ':Attribute harus antara :min dan :max digit',
    'dimensions' => ':Attribute memiliki dimensi gambar yang tidak valid',
    'distinct' => ':Attribute memiliki nilai yang duplikat',
    'email' => ':Attribute harus merupakan alamat email yang valid',
    'ends_with' => ':Attribute harus diakhiri dengan salah satu dari yang berikut: :values',
    'exists' => 'Yang dipilih :Attribute tidak valid',
    'file' => ':Attribute harus berupa file',
    'filled' => ':Attribute harus memiliki nilai',
    'gt' => [
        'array' => ':Attribute harus memiliki lebih dari :value item',
        'file' => ':Attribute harus lebih dari :value kilobyte',
        'numeric' => ':Attribute harus lebih dari :value',
        'string' => ':Attribute harus lebih dari :value karakter',
    ],
    'gte' => [
        'array' => ':Attribute harus memiliki :value item atau lebih',
        'file' => ':Attribute harus lebih besar dari atau sama dengan :value kilobyte',
        'numeric' => ':Attribute harus lebih besar dari atau sama dengan :value',
        'string' => ':Attribute harus lebih besar dari atau sama dengan :value karakter',
    ],
    'image' => ':Attribute harus berupa gambar',
    'in' => 'Yang dipilih :Attribute tidak valid',
    'integer' => ':Attribute harus berupa bilangan bulat',
    'ip' => ':Attribute harus berupa alamat IP yang valid',
    'ipv4' => ':Attribute harus berupa alamat IPv4 yang valid',
    'ipv6' => ':Attribute harus berupa alamat IPv6 yang valid',
    'json' => ':Attribute harus berupa string JSON yang valid',
    'lowercase' => ':Attribute harus berupa huruf kecil',
    'lt' => [
        'array' => ':Attribute harus memiliki kurang dari :value item',
        'file' => ':Attribute harus kurang dari :value kilobyte',
        'numeric' => ':Attribute harus kurang dari :value',
        'string' => ':Attribute harus kurang dari :value karakter',
    ],
    'lte' => [
        'array' => ':Attribute tidak boleh memiliki lebih dari :value item',
        'file' => ':Attribute harus kurang dari atau sama dengan :value kilobyte',
        'numeric' => ':Attribute harus kurang dari atau sama dengan :value',
        'string' => ':Attribute harus kurang dari atau sama dengan :value karakter',
    ],
    'mac_address' => ':Attribute harus berupa alamat MAC yang valid',
    'max' => [
        'array' => ':Attribute tidak boleh memiliki lebih dari :max item',
        'file' => ':Attribute tidak boleh lebih dari :max kilobyte',
        'numeric' => ':Attribute tidak boleh lebih dari :max',
        'string' => ':Attribute tidak boleh lebih dari :max karakter',
    ],
    'mimes' => ':Attribute harus berupa file dengan tipe: :values',
    'mimetypes' => ':Attribute harus berupa file dengan tipe: :values',
    'min' => [
        'array' => ':Attribute harus memiliki setidaknya :min item',
        'file' => ':Attribute harus setidaknya :min kilobyte',
        'numeric' => ':Attribute harus setidaknya :min',
        'string' => ':Attribute harus setidaknya :min karakter',
    ],
    'not_in' => 'Yang dipilih :Attribute tidak valid',
    'numeric' => ':Attribute harus berupa angka',
    'required' => ':Attribute harus diisi',
    'same' => ':Attribute harus cocok dengan :other',
    'size' => [
        'array' => ':Attribute harus berisi :size item',
        'file' => ':Attribute harus :size kilobyte',
        'numeric' => ':Attribute harus :size',
        'string' => ':Attribute harus :size karakter',
    ],
    'string' => ':Attribute harus berupa string',
    'timezone' => ':Attribute harus merupakan zona waktu yang valid',
    'unique' => ':Attribute sudah digunakan',
    'url' => ':Attribute harus berupa URL yang valid',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

    'click_button' => "Jika Anda mengalami kesulitan mengklik tombol \":actionText\", salin dan tempel URL di bawah ini ke\n peramban web Anda:",

];
