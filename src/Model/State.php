<?php

namespace Everlution\Fsm\Model;

class State
{
    private $name;

    private $description;

    public function __construct($name, $description = null)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
