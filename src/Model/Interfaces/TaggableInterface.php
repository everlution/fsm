<?php

namespace Everlution\Fsm\Model\Interfaces;

interface TaggableInterface
{
    public function addTag($name, $value);

    public function setTags(array $tags);

    public function getTags();
}
