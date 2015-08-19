<?php

include 'MyObj.php';

use Everlution\Fsm\Model\DefaultFsm;
use AppBundle\Fsm\Model\State\InitialState;
use AppBundle\Fsm\Model\State\FinalState;
use Everlution\Fsm\Model\State;
use Everlution\Fsm\Model\Transition;
use Everlution\Fsm\Model\Grant;

$fsm = new DefaultFsm();

$fsm
    ->addState(new InitialState('s1'))
    ->addState(new State('s2'))
    ->addState(new State('s3'))
    ->addState(new State('s4'))
    ->addState(new FinalState('s5'))
;

$t1 = new Transition('t1', 's1', 's2');
$t2 = new Transition('t2', 's1', 's3');
$t2
    ->addGrant(new Grant('g1'))
    ->addGrant(new Grant('g2'))
;
$t3 = new Transition('t3', 's2', 's4');
$t4 = new Transition('t4', 's4', 's5');
$t5 = new Transition('t5', 's3', 's1');

$fsm
    ->addTransition($t1)
    ->addTransition($t2)
    ->addTransition($t3)
    ->addTransition($t4)
    ->addTransition($t5)
;

$myObj = new MyObj();

$fsm->setInitialState($myObj);

$myObj
    ->addCurrentGrantName('g1')
    ->addCurrentGrantName('g2')
;

$fsm->doTransition($myObj, 't2');

echo $myObj->getCurrentStateName();
