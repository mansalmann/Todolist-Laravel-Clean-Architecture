<?php

namespace Tests\Feature;

use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp():void
    {
        parent::setUp();
        DB::delete("delete from users");

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        self::assertTrue($this->userService->login("user@localhost","user"));
    }
    public function testLoginFailed()
    {
        self::assertFalse($this->userService->login("salma","123"));
    }
    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login("user","12345"));
    }
}
