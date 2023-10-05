<?php

namespace IPVC;

class Attribute
{
    private $id = 0,
        $name = '',
        $meta = [];

    public function __construct($name = '')
    {
        $this->setName($name);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of meta
     */
    public function getMeta($key = '')
    {
        if (!empty($key) && isset($this->meta[$key])) {
            return $this->meta[$key];
        }
        return $this->meta;
    }

    /**
     * Set the value of meta
     *
     * @return  self
     */
    public function setMeta($metaName, $meta)
    {
        $this->meta[$metaName] = $meta;
        return $this;
    }

    public function __get($prop)
    {

        return $this->$prop;
    }
    public function __isset($prop): bool
    {
        return isset($this->$prop);
    }
}
