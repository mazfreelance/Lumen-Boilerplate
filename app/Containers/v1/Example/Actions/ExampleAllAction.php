<?php

namespace App\Containers\v1\Example\Actions;

use App\Containers\v1\Example\DTO\ExampleAllDTO;

class ExampleAllAction
{
    public function execute(ExampleAllDTO $dto)
    {
        return $dto->toArray();
    }
}
