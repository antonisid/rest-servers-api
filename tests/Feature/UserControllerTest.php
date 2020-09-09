<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test register()
     */
    public function testRegister(): void
    {
        $user = factory(User::class)->make();

        $response = $this->json('POST', '/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertSee('token');
    }

    /**
     * Test login()
     */
    public function testLogin(): void
    {
        $user = factory(User::class)->make();

        $this->json('POST', '/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('token');
    }

    /**
     * Test login()
     */
    public function testCannotLoginWhenInputValidationFails(): void
    {
        $user = factory(User::class)->make();

        $this->json('POST', '/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertDontSee('token');
    }

    /**
     * Test register()
     */
    public function testCannotRegisterWhenInputValidationFails(): void
    {
        $user = factory(User::class)->make(['email' => 'testdemo.com']);

        $response = $this->json('POST', '/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertDontSee('token');
    }
}
