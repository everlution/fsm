<?php

namespace Everlution\Fsm\Model;

use Everlution\Fsm\StatableInterface;
use Everlution\Fsm\Exception\FsmException;

class DefaultFsm implements FsmInterface
{
    private $states;

    private $transitions;

    public function __construct()
    {
        $this->states = array();
        $this->transitions = array();
    }

    public function addState(State $state)
    {
        if (!$state->getName()) {
            throw new FsmException('The state must have a name');
        }

        if ($state instanceof State\InitialState && $this->getInitialState()) {
            throw new FsmException('Cannot add more than one initial state');
        }

        $this->states[$state->getName()] = $state;

        return $this;
    }

    public function addTransition(Transition $transition)
    {
        if (!$transition->getName()) {
            throw new FsmException('The transition must have a name');
        }

        if (!isset($this->states[$transition->getFromStateName()])) {
            throw new FsmException('The transition from state does not exists');
        }

        if (!isset($this->states[$transition->getToStateName()])) {
            throw new FsmException('The transition to state does not exists');
        }

        $this->transitions[$transition->getName()] = $transition;

        return $this;
    }

    public function getInitialState()
    {
        foreach ($this->states as $state) {
            if ($state instanceof State\InitialState) {
                return $state;
            }
        }
        return false;
    }

    public function setInitialState(StatableInterface $object)
    {
        $initialState = $this->getInitialState();

        if (!$initialState) {
            throw new FsmException('The FSM must specify one initial state');
        }

        $object->setCurrentStateName($initialState->getName());
    }

    public function isInInitialState(StatableInterface $object)
    {
        $stateName = $object->getCurrentStateName();

        $state = isset($this->states[$stateName]) ?
            $this->states[$stateName] :
            null
        ;

        return $state && $state instanceof State\InitialState;
    }

    public function isInFinalState(StatableInterface $object)
    {
        $stateName = $object->getCurrentStateName();

        $state = isset($this->states[$stateName]) ?
            $this->states[$stateName] :
            null
        ;

        return $state && $state instanceof State\FinalState;
    }

    /**
     * @param string $stateName
     * @return \AppBundle\Fsm\Model\State
     */
    public function getStateByName($stateName)
    {
        return isset($this->states[$stateName]) ?
            $this->states[$stateName] :
            null
        ;
    }

    /**
     * @param string $transitionName
     * @return \AppBundle\Fsm\Model\Transition
     */
    public function getTransitionByName($transitionName)
    {
        return isset($this->transitions[$transitionName]) ?
            $this->transitions[$transitionName] :
            null
        ;
    }

    public function hasAllTransitionGrants(StatableInterface $object, Transition $transition)
    {
        $currentGrantsNames = $object->getCurrentStateGrantsNames();

        $requiredGrants = $transition->getGrants();

        foreach ($requiredGrants as $grant) {
            if (!in_array($grant->getName(), $currentGrantsNames)) {
                return false;
            }
        }

        return true;
    }

    public function doTransition(StatableInterface $object, $transitionName, $throwException = true)
    {
        // find transition
        $transition = $this->getTransitionByName($transitionName);

        // check if from state is OK
        if ($object->getCurrentStateName() != $transition->getFromStateName()) {
            if ($throwException) {
                throw new FsmException('The transition is invalid for the current state');
            } else {
                return false;
            }
        }

        // check if all the grants are OK
        if (!$this->hasAllTransitionGrants($object, $transition)) {
            if ($throwException) {
                throw new FsmException('The transition cannot be executed due to grants missing');
            } else {
                return false;
            }
        }

        // execute transition
        $object->setCurrentStateName($transition->getToStateName());

        // remove all the current conditions
        $object->removeAllCurrentStateGrants();

        return true;
    }
}
