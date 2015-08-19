<?php

namespace Everlution\Fsm\Model;

interface FsmInterface
{
    public function addState(State $state, $isInitial = false);

    public function addTransition(Transition $transition);
}
