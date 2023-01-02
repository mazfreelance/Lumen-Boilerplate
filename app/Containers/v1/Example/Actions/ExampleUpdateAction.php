<?php

namespace App\Containers\v1\Example\Actions;

use App\Containers\v1\Example\DTO\ExampleUpdateDTO;

class ExampleUpdateAction
{
    public function execute(ExampleUpdateDTO $dto)
    {
        return $dto->toArray();
    }
}
