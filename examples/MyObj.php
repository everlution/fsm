<?php

class MyObj implements \EverlutionFsm\StatableInterface
{
    private $currentState;

    private $currentGrants;

    public function __construct()
    {
        $this->currentGrants = array();
    }

    public function addCurrentGrantName($grantName)
    {
        $this->currentGrants[] = $grantName;

        return $this;
    }

    public function getCurrentGrantsNames()
    {
        return $this->currentGrants;
    }

    public function getCurrentStateName()
    {
        return $this->currentState;
    }

    public function removeAllCurrentGrants()
    {
        $this->currentGrants = array();

        return $this;
    }

    public function setCurrentStateName($stateName)
    {
        $this->currentState = $stateName;

        return $this;
    }
}
