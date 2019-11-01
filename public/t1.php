<?php
class Container {
    private $s=array();
    function __set($k, $c) { $this->s[$k]=$c; }
    function __get($k){
        return $this->s[$k];
    }
}

//注入b
$c = new Container();
$c->B = new B();

class B{
    public function tb()
    {
        echo 'tb';
    }
}

class A
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function doSomeThing()
    {
        $b = $this->container->B;
        $b->tb();
    }
}

//
$A = new A($c);
$A->doSomeThing();


