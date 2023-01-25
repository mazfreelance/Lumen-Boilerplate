<?php

namespace App\Containers\v1\Example\Controllers;

use App\Containers\v1\Example\DTO\{ExampleAllDTO, ExampleStoreDTO, ExampleUpdateDTO};
use App\Ship\Controllers\Controller as BaseController;
use App\Ship\Support\Facades\{Executor, Responder};
use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Executor::setApiVersion('v1');
    }

    public function index(Request $request)
    {
        $exampleDTO = ExampleAllDTO::from($request);
        return $exampleAction = Executor::run('Example@ExampleAllAction', $exampleDTO);
        // return Responder::success(Example::collection($exampleAction));
    }

    public function show(int $id)
    {
        $exampleAction = Executor::run('Example@ExampleOneAction', $id);
        return Responder::success($exampleAction, __('message.success_retrieved'));
        // return Responder::success(new Example($exampleAction), __('message.success_retrieved'));
    }

    public function store(Request $request)
    {
        $exampleDTO = ExampleStoreDTO::from($request);
        $exampleAction = Executor::run('Example@ExampleStoreAction', $exampleDTO);
        return Responder::success($exampleAction, __('message.success_save'));
    }

    public function update(Request $request)
    {
        $exampleDTO = ExampleUpdateDTO::from($request);
        $exampleAction = Executor::run('Example@ExampleUpdateAction', $exampleDTO);
        return Responder::success($exampleAction, __('message.success_save'));
    }

    public function destroy(int $id)
    {
        $exampleAction = Executor::run('Example@ExampleDeleteAction', $id);
        return Responder::success([], __('message.success_delete'));
    }
}
