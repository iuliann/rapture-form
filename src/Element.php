<?php

namespace Rapture\Form;

/**
 * Base html element
 *
 * @package Rapture\Form
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Element
{
    protected $attributes = [];

    protected $meta = [
        'label'   => '',
        'options' => [],
        'html'    => '',
    ];

    protected $scope;

    /**
     * __construct()
     *
     * @param string $name       Element name
     * @param mixed  $value      Element value
     * @param array  $attributes Element attributes
     * @param array  $meta       Extra meta information
     * @param string $scope      Element scope
     */
    public function __construct($name = 'form', $value = null, array $attributes = [], array $meta = [], $scope = null)
    {
        $this->meta = $meta + $this->meta;
        $this->attributes += ['name' => $name] + $attributes;
        $this->setValue($value);

        $this->init($scope ?: $name);
    }

    /**
     * init method to avoid overwriting construct
     *
     * @param string $scope Scope of init
     *
     * @return void
     */
    protected function init($scope = null)
    {
        $this->scope = $scope;
    }

    /**
     * Set element attributes
     *
     * @param array $attributes Key value pair
     *
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes + $this->attributes;

        return $this;
    }

    /**
     * Get element attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set single attribute
     *
     * @param string $name  Attribute name
     * @param mixed  $value Attribute value
     *
     * @return $this
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * getAttribute
     *
     * @param string $name    Attribute name
     * @param mixed  $default Default value if attribute not set
     *
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return array_key_exists($name, $this->attributes)
            ? $this->attributes[$name]
            : $default;
    }

    /**
     * By default Element is input
     *
     * @return string
     */
    public function getTag()
    {
        return 'input';
    }

    /**
     * Get type of element.
     * For input it returns the input type. Returns tag otherwise.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getTag() == 'input' ? $this->getAttribute('type', 'text') : $this->getTag();
    }

    /**
     * Get form element value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->attributes['value'] === ''
            ? null
            : $this->attributes['value'];
    }

    /**
     * Set form element value
     *
     * @param mixed $value Element value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }

    /**
     * Set element label
     *
     * @param string $label Value
     *
     * @return $this
     */
    public function setLabel($label = '')
    {
        $this->meta['label'] = $label;

        return $this;
    }

    /**
     * Get element label
     *
     * @return string
     */
    public function getLabel()
    {
        return isset($this->meta['label']) ? $this->meta['label'] : '';
    }

    /**
     * Get element meta
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
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
        return isset($this->attributes['class'])
            ? $this->attributes['class']
            : $default;
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

            $this->attributes['class'] = trim($this->getClass() . ' ' . $class);
        }

        return $this;
    }

    /**
     * Check if element has class
     *
     * @param string $class Class to search
     *
     * @return bool
     */
    public function hasClass($class = '')
    {
        return isset($class[0]) && strpos(' ' . $this->getClass() . ' ', " {$class} ") !== false;
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

            $this->attributes['class'] = $class . ' ' . trim($this->getClass());
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
            $this->attributes['class'] = trim(str_replace(" {$class} ", ' ', " {$this->getClass()} "));
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
            strpos(" {$this->attributes['class']} ", $class) !== false
                ? $this->removeClass($class)
                : $this->appendClass($class);
        }

        return $this;
    }

    /**
     * Get scope of element
     *
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /*
    * Attributes
    */

    /**
     * Check if is disabled
     *
     * @return bool
     */
    public function isDisabled()
    {
        return isset($this->attributes['disabled']) && (bool)$this->attributes['disabled'];
    }

    /**
     * Check if is readonly
     *
     * @return bool
     */
    public function isReadonly()
    {
        return isset($this->attributes['readonly']) && (bool)$this->attributes['readonly'];
    }

    /**
     * Check if is required
     *
     * @return bool
     */
    public function isRequired()
    {
        return isset($this->attributes['required']) && (bool)$this->attributes['required'];
    }
}
