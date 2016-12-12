<?php

namespace Everlution\Fsm\Model;

use Everlution\Fsm\StatableInterface;
use Everlution\Fsm\Exception\FsmException;

class DefaultFsm implements FsmInterface
{
    /**
     * @var string[]
     */
    private $states;

    /**
     * @var Transition[]
     */
    private $transitions;

    public function __construct()
    {
        $this->states = array();
        $this->transitions = array();
    }

    public function addState(State $state)
    {
        if ($state->getName() === null) {
            throw new FsmException('The state must have a name');
        }

        if ($state instanceof InitialState && $this->getInitialState()) {
            throw new FsmException('Cannot add more than one initial state');
        }

        $this->states[$state->getName()] = $state;

        return $this;
    }

    /**
     * @return \Everlution\Fsm\Model\State[]
     */
    public function getStates()
    {
        return $this->states;
    }

    public function addTransition(Transition $transition)
    {
        if ($transition->getName() === null) {
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

    /**
     * @return \Everlution\Fsm\Model\Transition[]
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    public function getInitialState()
    {
        foreach ($this->states as $state) {
            if ($state instanceof InitialState) {
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

        return $state && $state instanceof InitialState;
    }

    public function isInFinalState(StatableInterface $object)
    {
        $stateName = $object->getCurrentStateName();

        $state = isset($this->states[$stateName]) ?
            $this->states[$stateName] :
            null
        ;

        return $state && $state instanceof FinalState;
    }

    /**
     * @param string $stateName
     * @return \Everlution\Fsm\Model\State
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
     * @return \Everlution\Fsm\Model\Transition
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
                throw new FsmException(sprintf(
                    'Transition<%s> from state<%s> to state<%s> is invalid for the current state<%s>',
                    $transition->getName(),
                    $transition->getFromStateName(),
                    $transition->getToStateName(),
                    $object->getCurrentStateName()
                ));
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

    /**
     * @param $state
     * @return string[]
     */
    public function getNextAvailableStates($state)
    {
        $nextStates = array();

        foreach ($this->transitions as $transition) {
            if ($transition->getFromStateName() == $state) {
                $nextStates[] = $transition->getToStateName();
            }
        }

        return $nextStates;
    }

    /**
     * @param $state
     * @return Transition[]
     */
    public function getAvailableTransitions($state)
    {
        $transitions = array();

        foreach ($this->transitions as $transition) {
            if ($transition->getFromStateName() == $state) {
                $transitions[] = $transition;
            }
        }

        return $transitions;
    }

    public function getFinalStates()
    {
        $finalStates = array();
        foreach ($this->states as $state) {
            if ($state instanceof FinalState) {
                $finalStates[] = $state;
            }
        }

        return $finalStates;
    }

    public function getFinalStatesNames()
    {
        $finalStates = array();
        foreach ($this->states as $state) {
            if ($state instanceof FinalState) {
                $finalStates[] = $state->getName();
            }
        }

        return $finalStates;
    }

    public function getNonFinalStates()
    {
        $nonFinalStates = array();
        foreach ($this->states as $state) {
            if (!$state instanceof FinalState) {
                $nonFinalStates[] = $state;
            }
        }

        return $nonFinalStates;
    }

    public function getNonFinalStatesNames()
    {
        $nonFinalStates = array();
        foreach ($this->states as $state) {
            if (!$state instanceof FinalState) {
                $nonFinalStates[] = $state->getName();
            }
        }

        return $nonFinalStates;
    }
}
