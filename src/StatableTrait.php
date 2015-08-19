<?php

namespace Everlution\Fsm;

trait StatableTrait
{
    private $currentState;

    private $currentStateGrants;

    public function __construct()
    {
        $this->currentStateGrants = array();
    }

    public function addCurrentStateGrantName($grantName)
    {
        $this->currentStateGrants[] = $grantName;

        return $this;
    }

    public function getCurrentStateGrantsNames()
    {
        return $this->currentStateGrants;
    }

    public function getCurrentStateName()
    {
        return $this->currentState;
    }

    public function removeAllCurrentStateGrants()
    {
        $this->currentStateGrants = array();

        return $this;
    }

    public function setCurrentStateName($stateName)
    {
        $this->currentState = $stateName;

        return $this;
    }
}
