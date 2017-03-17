<?php

namespace Rapture\Form;

/**
 * Form textarea element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Textarea extends Button
{
    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return 'textarea';
    }
}
