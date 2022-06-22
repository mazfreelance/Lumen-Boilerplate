<?php

namespace App\Containers\v1\Example\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @reference https://github.com/spatie/data-transfer-object
 */
class ExampleStoreDTO extends DataTransferObject
{
    public $example_1;

    public $example_2;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'example_1' => $request->example_1,
            'example_2' => $request->example_2,
        ]);
    }

}
