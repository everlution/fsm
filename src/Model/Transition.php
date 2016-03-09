<?php

namespace Everlution\Fsm\Model;

use Everlution\Fsm\Model\Interfaces\TaggableInterface;
use Everlution\Fsm\Model\Traits\TaggableTrait;

class Transition implements TaggableInterface
{
    use TaggableTrait;

    private $name;

    private $fromStateName;

    private $toStateName;

    private $grants;

    public function __construct($name, $fromStateName, $toStateName, array $tags = array())
    {
        $this->name = $name;
        $this->fromStateName = $fromStateName;
        $this->toStateName = $toStateName;
        $this->tags = $tags;
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
}
