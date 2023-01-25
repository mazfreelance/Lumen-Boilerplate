<?php

use App\Containers\v1\User\Models\User;
use App\Ship\Support\Facades\Responder;
use Tests\TestCase;
use Illuminate\Http\JsonResponse;

/**
 * @coversDefaultClass \App\Ship\Support\Responder
 */
class ResponderTest extends TestCase
{
    /**
     * Can return success response test
     *
     * @covers ::success
     */
    public function testReturnSuccessResponse()
    {
        $response = Responder::success([], 'test success response');
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertArrayHasKey("data", $result);
        $this->assertEquals(JsonResponse::HTTP_OK, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Can return not found response test
     *
     * @covers ::notFound
     */
    public function testReturnNotFoundResponse()
    {
        $response = Responder::notFound();
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * Can return input error response test
     *
     * @covers ::inputError
     */
    public function testReturnInputErrorResponse()
    {
        $response = Responder::inputError([]);
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertArrayHasKey("errors", $result);
        $this->assertEquals(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * Can return server error response test
     *
     * @covers ::serverError
     */
    public function testReturnServerErrorResponse()
    {
        $response = Responder::serverError('test server error');
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * Can return error response test
     *
     * @covers ::error
     */
    public function testReturnErrorResponse()
    {
        $response = Responder::error('test error');
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * Can return unauthorized response test
     *
     * @covers ::unauthorized
     */
    public function testReturnUnauthorizedResponse()
    {
        $response = Responder::unauthorized();
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * Can return forbidden access response test
     *
     * @covers ::forbiddenAccess
     */
    public function testReturnForbiddenAccessResponse()
    {
        $response = Responder::forbiddenAccess();
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * Can return forbidden manage response test
     *
     * @covers ::forbiddenManage
     */
    public function testReturnForbiddenManageResponse()
    {
        $response = Responder::forbiddenManage();
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * Can return forbidden action response test
     *
     * @covers ::forbiddenAction
     */
    public function testReturnForbiddenActionResponse()
    {
        $response = Responder::forbiddenAction();
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * Can return forbidden login response test
     *
     * @covers ::forbiddenLogin
     */
    public function testReturnForbiddenLoginResponse()
    {
        $response = Responder::forbiddenLogin();
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * Can return collection response test
     *
     * @covers ::collection
     */
    public function testCollectionResponse()
    {
        $response = Responder::success(User::paginate(10));
        $result = $response->original;

        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("message", $result);
        $this->assertArrayHasKey("data", $result);
        $this->assertEquals(JsonResponse::HTTP_OK, $result['code']);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }
}
