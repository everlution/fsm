<?php

namespace Everlution\Fsm;

interface StatableInterface
{
    public function setCurrentStateName($stateName);

    public function getCurrentStateName();

    public function addCurrentStateGrantName($grantName);

    public function getCurrentStateGrantsNames();

    public function removeAllCurrentStateGrants();
}
