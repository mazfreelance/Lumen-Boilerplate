<?php

namespace App\Containers\v1\Example\DTO;

use Spatie\LaravelData\{Data, Optional};
use Spatie\LaravelData\Attributes\{MapInputName, MapOutputName};

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ExampleStoreDTO extends Data
{
    public function __construct(
        #[MapInputName('example_1')]
        #[MapOutputName('example_1')]
        public string $exampleOne,

        #[MapInputName('example_2')]
        #[MapOutputName('example_2')]
        public string $exampleTwo
    ) {}
}
