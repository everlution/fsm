<?php

namespace Everlution\Fsm\Model\Traits;

trait TaggableTrait
{
    private $tags = array();

    public function addTag($name, $value)
    {
        $this->tags[$name] = $value;

        return $this;
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getTag($name, $default = null)
    {
        return isset($this->tags[$name]) ? $this->tags[$name] : $default;
    }
}
