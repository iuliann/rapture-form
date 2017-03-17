<?php

namespace Rapture\Form;

/**
 * Form autocomplete element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Autocomplete extends Element
{
    protected $value;

    /**
     * @param string $name       Element name
     * @param null   $value      Element value
     * @param array  $attributes Element attributes
     * @param array  $meta       Element meta
     * @param null   $scope      Element scope
     */
    public function __construct($name, $value = null, array $attributes = [], array $meta = [], $scope = null)
    {
        $value = (array)$value + [null, null];
        $this->meta = $meta + $this->meta;
        $this->attributes += $attributes + ['name' => "{$name}[]", 'value' => $value[0]];

        $this->attributes['type'] = 'text';
        $this->meta['after'] = sprintf('<input type="hidden" name="%s" value="%s" />', "{$name}[]", $value[1]);

        $this->init($scope ?: $name);
    }

    /**
     * setValue
     *
     * @param mixed $value Array or scalar
     *
     * @return $this
     */
    public function setValue($value)
    {
        $value = (array)$value + [null, null];

        $this->attributes['value'] = $value[0];
        $this->value = strlen($value[1]) ? $value[1] : $value[0];
        $this->meta['after'] = sprintf(
            '<input type="hidden" name="%s" value="%s" />',
            $this->attributes['name'],
            $value[1]
        );

        return $this;
    }

    /**
     * getValue
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value === '' ? null : $this->value;
    }
}
