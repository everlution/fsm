<?php

namespace Everlution\Fsm\Model;

interface FsmInterface
{
    public function addState(State $state);

    public function addTransition(Transition $transition);
}
