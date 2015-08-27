<?php

namespace Pckg\Htmlbuilder\Snippet;

/**
 * Class Attributes
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
     * @param $key
     * @param string $val
     * @return $this
     */
    public function setAttribute($key, $val = '')
    {
        $this->attributes[$key] = $val;

        return $this;
    }

    /*
    Set attribute
    */
    /**
     * @param $key
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
     * @param $key
     * @param null $default
     * @return null
     */
    public function getAttribute($key, $default = null)
    {
        return isset($this->attributes[$key])
            ? $this->attributes[$key]
            : $default;
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
    Unsets previously set attribute
    */
    /**
     * @param $key
     * @return $this
     */
    public function unsetAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /*
    Appends $val to attribute $key and uses $split as separator
    */
    /**
     * @param $key
     * @param $val
     * @param string $split
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
    Prepends $val to attribute $key and uses $split as separator
    */
    /**
     * @param $key
     * @param $val
     * @param string $split
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
    Builds attributes HTML
    */
    /**
     * @param bool $escape
     * @return string
     */
    public function buildAttributes($escape = true)
    {
        $html = "";

        foreach ($this->attributes AS $key => $val) {
            $html .= " " . $key . (!is_null($val) ? '="' . ($escape ? htmlspecialchars($val) : $val) . '"' : '');
        }

        return $html;
    }

    /**
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);

        return $this;
    }

    /*
      Sets element's attribute class
    */
    /**
     * @param null $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->classes = [];
        $this->addClass($class);

        return $this;
    }

    public function removeClass($class)
    {
        foreach (explode(' ', $class) as $c) {
            if (($key = array_search($c, $this->classes)) !== false) {
                unset($this->classes[$key]);
            }
        }

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
     * @param $class
     * @return bool
     */
    public function hasClass($class)
    {
        foreach (explode(' ', $class) as $c) {
            if (!in_array($c, $this->classes)) {
                return false;
            }
        }

        return true;
    }

    /*
      Gets element's attribute class
    */
    /**
     * @return null
     */
    public function getClass()
    {
        return $this->getAttribute("class");
    }

    /*
      Adds class
    */
    /**
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        foreach (explode(' ', $class) AS $c) {
            if (!(in_array($c, $this->classes))) {
                $this->classes[] = $c;
            }
        }
        $this->rebuildClass();

        return $this;
    }
    /*
      Sets value for attribute name
    */
    /**
     * @param null $name
     * @return $this
     */
    public function setName($name = null)
    {
        $this->setAttribute("name", $name);

        return $this;
    }

    /*
      Gets value for attribute name
    */
    /**
     * @return null
     */
    public function getName()
    {
        return $this->getAttribute("name");
    }

    /*
      Sets value for attribute name
    */
    /**
     * @param null $id
     * @return $this
     */
    public function setID($id = null)
    {
        $this->setAttribute("id", $id);

        return $this;
    }

    /*
      Gets value for attribute id
    */
    /**
     * @return null
     */
    public function getID()
    {
        return $this->getAttribute("id");
    }

    /**
     * @var null
     */
    protected $value = null;

    /*
    Sets value for attribute value
    */

    /**
     * @param null $value
     * @return $this
     */
    public function setValue($value = null)
    {
        $this->value = $value;
        $this->setAttribute('value', $value);

        return $this;
    }

    /*
      Gets value for attribute value
    */
    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

}