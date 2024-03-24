<?php 

namespace Core\Domain\Factory;

abstract class  AbstractFactory {
    abstract public function create($array);

}