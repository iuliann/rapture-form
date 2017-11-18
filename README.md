# Rapture PHP Form

[![PhpVersion](https://img.shields.io/badge/php-5.4-orange.svg?style=flat-square)](#)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#)

PHP OOP implementation for html forms.

## Requirements

- PHP v5.4
- php-hash, php-openssl

## Install

```
composer require mrjulio/rapture-form
```

## Quick start

```php
$element = new Textarea('comment');
echo Html::element($element);

// form
$form = new \Rapture\Form\Form('test');
$form->setElements([
    'username' => [
        'name'  =>  'username',
        'type'  => 'Text',
        'attributes' => [
            'class' => 'form-control'
        ],
        'meta' => [
            'help' => 'Your username'
        ]
    ]
]);
echo Html::element($form->getElement('username'));
```

## About

### Author

Iulian N. `rapture@iuliann.ro`

### Testing

```
cd ./test && phpunit
```

### License

Rapture PHP Form is licensed under the MIT License - see the `LICENSE` file for details.
