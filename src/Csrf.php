<?php

namespace Rapture\Form;

use Rapture\Session\Definition\SessionInterface;

/**
 * Form CSRF element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Csrf extends Element
{
    protected $attributes = [
        'type' => 'hidden',
    ];

    /**
     * init
     *
     * @param string $scope Scope
     *
     * @return void
     */
    public function init($scope = 'create')
    {
        /*
        * SessionObject MUST be sent via $name in __construct
        */
        /** @var \Rapture\Session\Definition\SessionInterface $session */
        $session = $this->getAttribute('name');

        if (!($session instanceof SessionInterface)) {
            throw new \InvalidArgumentException('Session adapter is missing.');
        }

        if ($scope == 'create') {
            $token = function_exists('openssl_random_pseudo_bytes')
                ? base64_encode(openssl_random_pseudo_bytes(32))
                : hash('sha512', mt_rand(0, mt_getrandmax()) . uniqid(rand(0, 100)));

            $this->attributes['value'] = $token;
            $this->attributes['name'] = 'csrf';

            $session->set('csrf-token', $token);

            return;
        }

        $this->attributes['value'] = $session->get('csrf-token');
    }
}
