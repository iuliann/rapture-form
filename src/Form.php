<?php

namespace Rapture\Form;

/**
 * Form element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Form extends Element
{
    protected $elements = [];

    /**
     * __construct()
     *
     * @param string $name       Form name / scope
     * @param array  $elements   Form elements
     * @param array  $attributes Element attributes
     * @param array  $meta       Extra meta information
     * @param string $scope      If is not provided then $name is used instead (backwards compatibility)
     */
    public function __construct($name = 'form', array $elements = [], array $attributes = [], array $meta = [], $scope = null)
    {
        $this->elements = $elements;
        $this->attributes += ['name' => $name] + $attributes;
        $this->meta = $meta + $this->meta;

        $this->init($scope ?: $name);
    }

    /**
     * Form set value (usually from post)
     *
     * @param array $values Value(s) to set
     *
     * @return $this
     */
    public function setValue($values = null)
    {
        foreach ((array)$values as $name => $value) {
            if (isset($this->elements[$name])) {
                $this->getElement($name)->setValue($value);
            }
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
        $value = [];

        foreach ($this->elements as $name => $element) {
            if ($this->getElement($name)->isDisabled() || !in_array($this->getElement($name)->getTag(), ['input', 'select', 'textarea'])) {
                continue;
            }

            $value[$name] = $this->getElement($name)->getValue();
        }

        return $value;
    }

    /**
     * hasElement
     *
     * @param string $name Element name
     *
     * @return bool
     */
    public function hasElement($name)
    {
        return isset($this->elements[$name]);
    }

    /**
     * Get an element
     *
     * @param string $name Element name
     *
     * @return Element
     */
    public function getElement($name)
    {
        if (!isset($this->elements[$name])) {
            throw new \InvalidArgumentException('Element name is missing: ' . $name);
        }

        if (is_array($this->elements[$name])) {

            $element = $this->elements[$name];

            // label
            if (!isset($element['meta']['label'])) {
                $element['meta']['label'] = isset($element['label'])
                    ? $element['label']
                    : ucwords(
                        str_replace('_', ' ', is_array($element['name']) ? $element['name'][0] : $element['name'])
                    );
                unset($element['label']);
            }

            // value
            if (!isset($element['attributes']['value'])) {
                $element['attributes']['value'] = isset($element['value'])
                    ? $element['value']
                    : null;
                unset($element['value']);
            }

            $element = array_replace_recursive(
                [
                    'type' => 'Text',
                    'name' => $name,
                    'meta' => [],
                    'attributes'=> ['value' => null],
                    'scope' => null, // count=0 for Collection
                    'count' => 0
                ],
                $element
            );

            $class = $element['type'][0] == '\\'
                ? $element['type']
                : 'Rapture\\Form\\' . $element['type'];

            /** @var Element $elementObject */
            $elementObject = new $class(
                $element['name'],
                isset($element['elements']) ? $element['elements'] : $element['attributes']['value'],
                $element['attributes'],
                $element['meta'],
                $element['count'] ?: $element['scope']
            );

            $this->elements[$name] = $elementObject;
        }

        return $this->elements[$name];
    }

    /**
     * addElement
     *
     * @param string $name
     * @param mixed  $data
     *
     * @return $this
     */
    public function addElement($name, $data)
    {
        $this->elements[$name] = $data;

        return $this;
    }

    /**
     * setElements
     *
     * @param array $elements
     *
     * @return $this
     */
    public function setElements(array $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * removeElement
     *
     * @param string $name
     *
     * @return $this
     */
    public function removeElement($name)
    {
        unset($this->elements[$name]);

        return $this;
    }

    /**
     * Get all form elements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * getNames
     *
     * @return array
     */
    public function getNames()
    {
        return array_keys($this->elements);
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return 'form';
    }
}
