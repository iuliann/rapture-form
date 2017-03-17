<?php

namespace Rapture\Form;

/**
 * Form collection element
 *
 * @deprecated
 *
 * @package Rapture\Form
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Collection extends Element
{
    protected $collection = [];

    /**
     * __construct()
     *
     * @param string $names Collection name
     * @param mixed $value Null or array of values
     * @param array $attributes Attributes for all elements
     * @param array $meta Meta for all elements
     * @param int $scope Scope
     */
    public function __construct($names, $value = null, array $attributes = [], array $meta = [], $scope = null)
    {
        $count = isset($meta['count']) ? (int)$meta['count'] : count((array)$names);

        $defaultMeta = [
            'label' => 'Collection',
            'options' => [],
            'html' => '',
            'class' => 'Text'
        ];

        if (!is_array($names)) {
            $names = array_fill(0, $count, $names);
        }

        foreach ($names as $index => $name) {
            $val = isset($value[$index])
                ? $value[$index]
                : $value;
            $meta = isset($meta[$index])
                ? $meta[$index] + $defaultMeta
                : $meta + $defaultMeta;
            $attr = isset($attributes[$index])
                ? ['value' => $val, 'name' => $name] + $attributes[$index]
                : ['value' => $val, 'name' => $name] + $attributes;

            $this->collection[$index] = [
                'class' => $meta['class'],
                'name' => $name,
                'attributes' => $attr,
                'meta' => $meta,
            ];
        }

        $this->init($scope);
    }

    /**
     * Convert arrays to objects
     *
     * @return void
     */
    protected function arrayToObject()
    {
        foreach ($this->collection as $index => $element) {
            if ($element instanceof Element) {
                continue;
            }

            $class = $element['class'][0] == '\\'
                ? $element['class']
                : 'Rapture\\Form\\' . $element['class'];

            $this->collection[$index] = new $class(
                $element['name'],
                $element['attributes']['value'],
                (array)$element['attributes'],
                (array)$element['meta']
            );
        }
    }

    /**
     * Get array of objects with elements
     *
     * @return array
     */
    public function getElements()
    {
        if (is_array(key($this->collection))) {
            $this->arrayToObject();
        }

        return $this->collection;
    }

    /**
     * getElement
     *
     * @param int $index Index of element in collection
     *
     * @return Element
     */
    public function getElement($index)
    {
        if (is_array($this->collection[$index])) {
            $this->arrayToObject();
        }

        return $this->collection[$index];
    }

    /**
     * setValue
     *
     * @param array $values Array of values
     *
     * @return $this
     */
    public function setValue($values)
    {
        $values = (array)$values;

        foreach ($values as $index => $value) {
            $this->getElement($index)->setValue($value);
        }

        return $this;
    }

    /**
     * getValue
     *
     * @return array
     */
    public function getValue()
    {
        if (is_array($this->collection)) {
            $this->arrayToObject();
        }

        $value = [];

        /** @var Element $element */
        foreach ($this->collection as $index => $element) {
            $value[$index] = $element->getValue();
        }

        return $value;
    }

    /**
     * getLabel
     *
     * @param int $index Index of element
     *
     * @return string
     */
    public function getLabel($index = 0)
    {
        if (isset($this->collection[$index])) {
            return $this->getElement($index)->getLabel();
        }
        else {
            return $this->getElement(key($this->collection))->getLabel();
        }
    }

    /*
    * CSS class attribute
    */

    /**
     * Get element class
     *
     * @param string $default Default class to return if value is not set
     *
     * @return string
     */
    public function getClass($default = '')
    {
        return $this->getElement(key($this->collection))->getClass($default);
    }

    /**
     * Append a css class
     *
     * @param string $class Class name
     *
     * @return $this
     */
    public function appendClass($class = '')
    {
        if ($class) {
            $this->removeClass($class);

            foreach ($this->collection as $index => $element) {
                $this->getElement($index)->appendClass($class);
            }
        }

        return $this;
    }

    /**
     * Prepend a css class
     *
     * @param string $class Class name
     *
     * @return $this
     */
    public function prependClass($class = '')
    {
        if ($class) {
            $this->removeClass($class);

            foreach ($this->collection as $index => $element) {
                $this->getElement($index)->prependClass($class);
            }
        }

        return $this;
    }

    /**
     * Remove a css class
     *
     * @param string $class Class name
     *
     * @return $this
     */
    public function removeClass($class = '')
    {
        if ($class) {
            foreach ($this->collection as $index => $element) {
                $this->getElement($index)->removeClass($class);
            }
        }

        return $this;
    }

    /**
     * Toggle a css class
     *
     * @param string $class Class name
     *
     * @return $this
     */
    public function toggleClass($class = '')
    {
        if ($class) {
            foreach ($this->collection as $index => $element) {
                $this->getElement($index)->toggleClass($class);
            }
        }

        return $this;
    }
}
