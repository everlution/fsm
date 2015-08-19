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

    public function setCurrentStateName($stateName)
    {
        $this->currentState = $stateName;

        return $this;
    }

    public function getCurrentStateName()
    {
        return $this->currentState;
    }

    public function addCurrentStateGrantName($grantName)
    {
        if (!in_array($grantName, $this->currentStateGrants)) {
            $this->currentStateGrants[] = $grantName;
        }

        return $this;
    }

    public function getCurrentStateGrantsNames()
    {
        return $this->currentStateGrants;
    }

    public function removeAllCurrentStateGrants()
    {
        $this->currentStateGrants = array();

        return $this;
    }
}
