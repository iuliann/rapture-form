<?php

namespace Rapture\Form;

/**
 * Form img element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Img extends Element
{
    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return 'img';
    }

    /**
     * setValue
     *
     * @param mixed $value Src attribute
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->attributes['src'] = $value;

        return $this;
    }

    /**
     * getValue
     *
     * @return mixed
     */
    public function getValue()
    {
        return isset($this->attributes['src']) ? $this->attributes['src'] : null;
    }
}
