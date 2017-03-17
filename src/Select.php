<?php

namespace Rapture\Form;

/**
 * Form select element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Select extends Element
{
    /**
     * __construct()
     *
     * @param string $name       Element name
     * @param mixed  $value      Element value
     * @param array  $attributes Element attributes
     * @param array  $meta       Extra meta information
     * @param string $scope      Scope
     */
    public function __construct($name, $value = null, array $attributes = [], array $meta = [], $scope = null)
    {
        parent::__construct($name, $value, $attributes, $meta);

        $this->meta = ['html' => $value] + $meta + $this->meta;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return 'select';
    }

    /**
     * Set select options
     *
     * @param array $options Select options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->meta['options'] = $options;

        return $this;
    }

    /**
     * Get select options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->meta['options'];
    }

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->meta['html'] === '' ? null : $this->meta['html'];
    }

    /**
     * Set value
     *
     * @param mixed $value Value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->meta['html'] = $value;

        return $this;
    }

    /**
     * Set multiple select
     *
     * @param int $size Select size
     *
     * @return $this
     */
    public function setMultiple($size = 2)
    {
        if ($size) {
            $this->attributes['multiple'] = 'multiple';
            $this->attributes['size'] = (int)$size;

            if (substr($this->attributes['name'], -2) != '[]') {
                $this->attributes['name'] .= '[]';
            }
        } else {
            unset($this->attributes['multiple']);
            unset($this->attributes['size']);

            if (substr($this->attributes['name'], -2) == '[]') {
                $this->attributes['name'] = substr($this->attributes['name'], 0, -2);
            }
        }

        return $this;
    }
}
