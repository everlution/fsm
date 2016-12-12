<?php

namespace Everlution\Fsm\Model;

use Everlution\Fsm\StatableInterface;

interface FsmInterface
{
    /**
     * @param State $state
     * @return FsmInterface
     */
    public function addState(State $state);

    /**
     * @return State
     */
    public function getStates();

    /**
     * @return InitialState|null
     */
    public function getInitialState();

    /**
     * @return FinalState[]
     */
    public function getFinalStates();

    /**
     * @param StatableInterface $object
     * @return FsmInterface
     */
    public function setInitialState(StatableInterface $object);

    /**
     * @param StatableInterface $object
     * @return bool
     */
    public function isInFinalState(StatableInterface $object);

    /**
     * @param $stateName
     * @return State|null
     */
    public function getStateByName($stateName);

    /**
     * @param $state
     * @return string[]
     */
    public function getNextAvailableStates($state);

    /**
     * @param Transition $transition
     * @return FsmInterface
     */
    public function addTransition(Transition $transition);

    /**
     * @return Transition[]
     */
    public function getTransitions();

    /**
     * @param $transitionName
     * @return Transition|null
     */
    public function getTransitionByName($transitionName);

    /**
     * @param StatableInterface $object
     * @param $transitionName
     * @param bool $throwException
     * @return bool
     */
    public function doTransition(StatableInterface $object, $transitionName, $throwException = true);

    /**
     * @param $state
     * @return Transition[]
     */
    public function getAvailableTransitions($state);
}
