<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     protected function setUp():void{
        parent::setUp();
        // DB::delete("delete from users");
     }

    public function testLoginPage()
    {
        $this->get("/login")
        ->assertSeeText("Halaman Login");
    }
    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $this->post("/login",[
            "user" => "user@localhost",
            "password" => "user"
        ])->assertRedirect("/")
        ->assertSessionHas("user","user@localhost");
    }
    public function testLoginPageMember(){
        $this->withSession([
            "user" => "user"
        ])->get("/login")
        ->assertRedirect("/");
    }
    public function testLoginPageAlreadyLogin(){
        $this->withSession([
            "user" => "user"
        ])->post("/login",[
            "user" => "user",
            "password" => "123"
        ])->assertRedirect("/");
    }
    public function testLoginValidationError()
    {
        $this->post("/login",[
            "user" => "",
            "password" => ""
        ])->assertSeeText("Username atau password wajib diisi");
    }
    public function testLoginFailed()
    {
        $this->post("/login",[
            "user" => "salma",
            "password" => "123"
        ])->assertSeeText("Username atau password salah");
    }
    public function testLogout()
    {
        $this->withSession(["user" => "user"])
        ->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }
    public function testLogoutGuest()
    {
        $this->post("/logout")
            ->assertRedirect("/");
    }

    
}
