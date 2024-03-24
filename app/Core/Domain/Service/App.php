<?php

namespace Core\Domain\Service;

use Core\Domain\Factory\AbstractFactory;
use DateTime;

class App {

    protected $factory;

    public function __construct(AbstractFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createApp(array $data): array{
        try {
            //code...
            $data['created_at'] = new DateTime();
            $data['updated_at'] = new DateTime();
            $app = $this->factory->create($data);
            return $app->toArray();
        } catch (\Throwable $th) {
            //throw $th;
            throw $th;
        }
    }

    public function setFactory(AbstractFactory $factory){
        $this->factory = $factory;
    }
}