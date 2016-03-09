<?php

namespace Everlution\Fsm\Model;

use Everlution\Fsm\Model\Interfaces\TaggableInterface;
use Everlution\Fsm\Model\Traits\TaggableTrait;

class State implements TaggableInterface
{
    use TaggableTrait;

    private $name;

    public function __construct($name, array $tags = array())
    {
        $this->name = $name;
        $this->tags = $tags;
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
}
