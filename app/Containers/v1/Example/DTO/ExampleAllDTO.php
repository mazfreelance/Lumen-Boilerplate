<?php

namespace App\Containers\v1\Example\DTO;

use Spatie\LaravelData\{Data, Optional};
use Spatie\LaravelData\Attributes\{MapInputName, MapOutputName};
use Spatie\LaravelData\Attributes\WithoutValidation;

/**
 * @reference https://spatie.be/docs/laravel-data/v2/getting-started/quickstart
 */
class ExampleAllDTO extends Data
{
    public function __construct(
        #[WithoutValidation]
        #[MapInputName('example_one')]
        #[MapOutputName('example_one')]
        public ?string $exampleOne,

        #[MapInputName('example_two')]
        #[MapOutputName('example_two')]
        public string $exampleTwo
    ) {}

    // overwriting attributes
    public static function attributes(): array
    {
        return [
            'example_one' => 'new name'
        ];
    }

    /**
     * to construct a custom rule object
     *
     * @reference https://laravel.com/docs/9.x/validation
     */
    public static function rules(): array
    {
        return [
            'example_one' => 'required|integer',
        ];
    }

    // overwriting error messages
    public static function messages(): array
    {
        return [
            'example_one.required' => 'A :attribute is required. Please enter the value',
            'example_one.integer' => 'An test is number integer',
        ];
    }
}
