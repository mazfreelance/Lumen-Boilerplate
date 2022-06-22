<?php

namespace App\Containers\v1\Example\Controllers;

use App\Containers\v1\Example\DTO\{ExampleAllDTO, ExampleStoreDTO, ExampleUpdateDTO};
use App\Containers\v1\Example\Requests\{StoreRequest, UpdateRequest};
use App\Containers\v1\Example\Resources\ExampleResource;
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
        $exampleDTO = ExampleAllDTO::fromRequest($request);
        $exampleAction = Executor::run('Example@ExampleAllAction', $exampleDTO);
        return Responder::collection(ExampleResource::collection($exampleAction));
    }

    public function show(int $id)
    {
        $exampleAction = Executor::run('Example@ExampleOneAction', $id);
        return Responder::success(new ExampleResource($exampleAction), __('message.success_retrieved'));
    }

    public function store(StoreRequest $request)
    {
        $exampleDTO = ExampleStoreDTO::fromRequest($request);
        $exampleAction = Executor::run('Example@ExampleStoreAction', $exampleDTO);
        return Responder::success($exampleAction, __('message.success_save'));
    }

    public function update(UpdateRequest $request)
    {
        $exampleDTO = ExampleUpdateDTO::fromRequest($request);
        $exampleAction = Executor::run('Example@ExampleUpdateAction', $exampleDTO);
        return Responder::success($exampleAction, __('message.success_save'));
    }

    public function destroy(int $id)
    {
        $exampleAction = Executor::run('Example@ExampleDeleteAction', $id);
        return Responder::success([], __('message.success_delete'));
    }
}
