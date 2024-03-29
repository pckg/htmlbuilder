<?php

namespace Pckg\Htmlbuilder\Snippet;

/**
 * Class Attributes
 *
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Attributes
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $classes = [];

    /*
    Set attribute
    */
    /**
     * @var null
     */
    protected $value;

    /*
    Set attribute
    */

    /**
     * @return $this
     */
    public function emptyAttribute($key)
    {
        $this->attributes[$key] = null;

        return $this;
    }

    /*
    Returns attribute or default
    */

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /*
    Returns attribute or default
    */

    /**
     * @param string $split
     *
     * @return $this
     */
    public function appendAttribute($key, $val, $split = " ")
    {
        if (!isset($this->attributes[$key])) {
            $this->attributes[$key] = "";
        }

        $this->attributes[$key] .= $split . $val;

        return $this;
    }

    /*
    Unsets previously set attribute
    */

    /**
     * @param string $split
     *
     * @return $this
     */
    public function prependAttribute($key, $val, $split = " ")
    {
        if (!isset($this->attributes[$key])) {
            $this->attributes[$key] = "";
        }

        $this->attributes[$key] = $val . $split . $this->attributes[$key];

        return $this;
    }

    /*
    Appends $val to attribute $key and uses $split as separator
    */

    /**
     * @param bool $escape
     *
     * @return string
     */
    public function buildAttributes($escape = true)
    {
        $html = "";

        foreach ($this->attributes as $key => $val) {
            $html .= " " . $key . (!is_null($val) ? '="' . ($escape ? htmlspecialchars($val) : $val) . '"' : '');
        }

        return $html;
    }

    /*
    Prepends $val to attribute $key and uses $split as separator
    */

    /**
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);

        return $this;
    }

    /*
    Builds attributes HTML
    */

    /**
     * @param string $val
     *
     * @return $this
     */
    public function setAttribute($key, $val = '')
    {
        $this->attributes[$key] = $val;

        return $this;
    }

    public function a($key, $val = '')
    {
        return $this->setAttribute($key, $val);
    }

    public function removeAttribute($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    public function setAttributes($attributes)
    {
        foreach ($attributes as $key => $val) {
            $this->setAttribute($key, $val);
        }

        return $this;
    }

    /**
     * @param null $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->classes = [];
        $this->addClass($class);

        return $this;
    }

    /*
      Sets element's attribute class
    */

    /**
     * @return $this
     */
    public function addClass($class)
    {
        foreach (explode(' ', $class) as $c) {
            if (!(in_array($c, $this->classes))) {
                $this->classes[] = $c;
            }
        }
        $this->rebuildClass();

        return $this;
    }

    /**
     * @return $this
     */
    protected function rebuildClass()
    {
        $this->setAttribute("class", implode(' ', $this->classes));

        if (!$this->getAttribute('class')) {
            $this->unsetAttribute('class');
        }

        return $this;
    }

    /**
     * @param null $default
     *
     * @return null
     */
    public function getAttribute($key, $default = null)
    {
        return isset($this->attributes[$key])
            ? $this->attributes[$key]
            : $default;
    }

    public function addAttribute($key, $value)
    {
        if (!isset($this->attributes[$key])) {
            $this->attributes[$key] = $value;
        } else {
            $this->attributes[$key] .= $value;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /*
      Gets element's attribute class
    */

    public function removeClass($class)
    {
        foreach (explode(' ', $class) as $c) {
            if (($key = array_search($c, $this->classes)) !== false) {
                unset($this->classes[$key]);
            }
        }

        return $this;
    }

    /*
      Adds class
    */

    /**
     * @return bool
     */
    public function hasClass($class)
    {
        $classes = is_array($class)
            ? $class
            : explode(' ', $class);

        foreach ($classes as $c) {
            if (!in_array($c, $this->classes)) {
                return false;
            }
        }

        return true;
    }
    /*
      Sets value for attribute name
    */

    /**
     * @return null
     */
    public function getClass()
    {
        return $this->getAttribute("class");
    }

    /*
      Gets value for attribute name
    */

    /**
     * @param null $name
     *
     * @return $this
     */
    public function setName($name = null)
    {
        $this->setAttribute("name", $name);

        return $this;
    }

    /*
      Sets value for attribute name
    */

    /**
     * @return null
     */
    public function getName()
    {
        return $this->getAttribute("name");
    }

    /*
      Gets value for attribute id
    */

    /**
     * @param null $id
     *
     * @return $this
     */
    public function setID($id = null)
    {
        $this->setAttribute("id", $id);

        return $this;
    }

    /**
     * @return null
     */
    public function getID()
    {
        return $this->getAttribute("id");
    }

    /*
    Sets value for attribute value
    */

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /*
      Gets value for attribute value
    */

    /**
     * @return $this
     */
    public function setValue(mixed $value)
    {
        $this->value = $value;
        $this->setAttribute('value', $value);

        return $this;
    }

    public function hasDefinedValue()
    {
        return isset($this->value) || !is_null($this->value) || $this->value;
    }
}
