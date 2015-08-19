<?php

namespace EverlutionFsm;

interface StatableInterface
{
    public function setCurrentStateName($stateName);

    public function getCurrentStateName();

    public function addCurrentGrantName($grantName);

    public function getCurrentGrantsNames();

    public function removeAllCurrentGrants();
}
