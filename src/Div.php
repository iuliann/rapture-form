<?php

namespace Rapture\Form;

/**
 * Form div element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Div extends Button
{
    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return 'div';
    }

    /**
     * getValue
     *
     * @return mixed|null
     */
    public function getValue()
    {
        return null;
    }
}
