<?php

namespace Everlution\Fsm\Model;

class Transition
{
    private $name;

    private $fromStateName;

    private $toStateName;

    private $grants;

    private $description;

    public function __construct($name, $fromStateName, $toStateName, $description = null)
    {
        $this->name = $name;
        $this->fromStateName = $fromStateName;
        $this->toStateName = $toStateName;
        $this->description = $description;
        $this->grants = array();
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

    public function setFromStateName($fromStateName)
    {
        $this->fromStateName = $fromStateName;

        return $this;
    }

    public function getFromStateName()
    {
        return $this->fromStateName;
    }

    public function setToStateName($toStateName)
    {
        $this->toStateName = $toStateName;

        return $this;
    }

    public function getToStateName()
    {
        return $this->toStateName;
    }

    public function addGrant(Grant $grant)
    {
        $this->grants[] = $grant;

        return $this;
    }

    public function getGrants()
    {
        return $this->grants;
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
