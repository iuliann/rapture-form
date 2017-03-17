<?php

namespace Rapture\Form;

/**
 * Form checkbox element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Checkbox extends Element
{
    protected $attributes = [
        'type'  => 'checkbox',
        'value' => 1,
    ];

    /**
     * Checkbox is marked as checked if provided value is the same as original
     *
     * @param mixed $value Value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->setChecked((bool)$value);

        return $this;
    }

    /**
     * getValue
     *
     * @return int
     */
    public function getValue()
    {
        return (int)$this->isChecked();
    }

    /**
     * Set checked
     *
     * @param bool $checked Mark as checked or unchecked
     *
     * @return $this
     */
    public function setChecked($checked = true)
    {
        if ($checked) {
            $this->attributes['checked'] = 'checked';
        } else {
            unset($this->attributes['checked']);
        }

        return $this;
    }

    /**
     * Check if is checked
     *
     * @return bool
     */
    public function isChecked()
    {
        return isset($this->attributes['checked']);
    }
}
