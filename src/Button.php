<?php

namespace Rapture\Form;

/**
 * Form button element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Button extends Element
{
    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return 'button';
    }

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->meta['html'];
    }

    /**
     * Set value
     *
     * @param mixed $value Html value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->meta['html'] = $value;

        return $this;
    }
}
