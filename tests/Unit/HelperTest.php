<?php

use App\Containers\v1\User\Models\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use App\Ship\Support\Facades\Helper;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Permission;

/**
 * @coversDefaultClass \App\Ship\Support\Helper
 */
class HelperTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Can generate password reset token test
     *
     * @covers ::generatePasswordResetToken
     */
    public function testCanGeneratePasswordResetToken()
    {
        $passwordResetToken = Helper::generatePasswordResetToken();

        $this->assertIsString($passwordResetToken);
        $this->assertEquals(64, strlen($passwordResetToken));
    }

    /**
     * Can check user is logged in and has role test
     *
     * @covers ::isLoggedInAndHasRole
     */
    public function testCanCheckUserIsLoggedInAndHasRole()
    {
        Role::create(['name' => 'test-role']);

        $this->user->assignRole('test-role');
        $this->actingAs($this->user)->assertTrue(Helper::isLoggedInAndHasRole('test-role'));
    }

    /**
     * Can check user is guest test
     *
     * @covers ::isGuestOrNotHasRole
     */
    public function testCanCheckUserIsGuest()
    {
        $this->assertTrue(Helper::isGuestOrNotHasRole('test-role'));
    }

    /**
     * Can check user not has role test
     *
     * @covers ::isGuestOrNotHasRole
     */
    public function testCanCheckUserNotHasRole()
    {
        Role::create(['name' => 'test-role']);

        $this->actingAs($this->user)->assertTrue(Helper::isGuestOrNotHasRole('test-role'));
    }

    /**
     * Can check user has any permission test
     *
     * @covers ::hasAnyPermission
     */
    public function testCanCheckUserHasAnyPermission()
    {
        Request::shouldReceive('user')
            ->once()
            ->andReturn($this->user);
        Permission::create(['name' => 'test-permission']);

        $this->user->givePermissionTo('test-permission');
        $this->actingAs($this->user)->assertNull(Helper::hasAnyPermission('test-permission'));
    }

    /**
     * Can convert string to array test
     *
     * @covers ::idsStringToArray
     */
    public function testCanConvertStringToArray()
    {
        $testIds = '1,2,3,4';
        $testIdsArray = Helper::idsStringToArray($testIds);

        $this->assertIsArray($testIdsArray);
        $this->assertCount(4, $testIdsArray);
    }

    /**
     * Cannot pass when user not login test
     *
     * @covers ::isLoggedInAndHasRole
     */
    public function testCannotPassWhenUserNotLogin()
    {
        Role::create(['name' => 'test-role']);

        $this->assertFalse(Helper::isLoggedInAndHasRole('test-role'));
    }

    /**
     * Cannot pass when user not assigned the role test
     *
     * @covers ::isLoggedInAndHasRole
     */
    public function testCannotPassWhenUserNotAssignedTheRole()
    {
        Role::create(['name' => 'test-role']);

        $this->actingAs($this->user)->assertFalse(Helper::isLoggedInAndHasRole('test-role'));
    }

    /**
     * Cannot pass when is not guest and has role test
     *
     * @covers ::isGuestOrNotHasRole
     */
    public function testCannotPassWhenIsNotGuestAndHasRole()
    {
        Role::create(['name' => 'test-role']);

        $this->user->assignRole('test-role');
        $this->actingAs($this->user)->assertFalse(Helper::isGuestOrNotHasRole('test-role'));
    }

    /**
     * Cannot pass when user is guest test
     *
     * @covers ::hasAnyPermission
     */
    public function testCannotPassWhenUserIsGuest()
    {
        Permission::create(['name' => 'test-permission']);

        $this->user->givePermissionTo('test-permission');

        try {
            Helper::hasAnyPermission('test-permission');
        } catch (Exception $exception) {
            $this->assertInstanceOf('Illuminate\Auth\Access\AuthorizationException', $exception);
            return;
        }

        $this->fail('failed to expect authorization exception');
    }

    /**
     * Cannot pass when user has no permission test
     *
     * @covers ::hasAnyPermission
     */
    public function testCannotPassWhenUserHasNoPermission()
    {
        Request::shouldReceive('user')
            ->once()
            ->andReturn($this->user);
        Permission::create(['name' => 'test-permission']);
        Passport::actingAs($this->user);

        try {
            Helper::hasAnyPermission('test-permission');
        } catch (Exception $exception) {
            $this->assertInstanceOf('Illuminate\Auth\Access\AuthorizationException', $exception);
            return;
        }

        $this->fail('failed to expect authorization exception');
    }
}
