<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    protected function setUp():void{

        parent::setUp();
        DB::delete("delete from todos");

    }
      public function testTodolist()
    {
        $this->seed(TodoSeeder::class);
        $this->withSession([
            "user" => "user@localhost",
        ])->get("/todolist")
        ->assertSeeText("1")->assertSeeText("salman");
    }
    
    public function testAddTodolistSuccess(){
        $this->withSession([
            "user" => "user@localhost"
        ])->post("/todolist", [
            "todo" => "salman"
        ])->assertRedirect("/todolist");
    }

    // public function testAddTodolistFailed(){
    //     $this->withSession([
    //         "user" => "user@localhost",
    //     ])->post("/todolist",[])
    //     ->assertSeeText("Todo harus diisi");
    // }
   
    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "user@localhost",
        ])->post("/todolist/1/delete")
        ->assertRedirect("/todolist");

}
}
