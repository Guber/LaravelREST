<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class TaskTest extends TestCase
{


  public function testTableEmpty()
  {
    DB::table('tasks')->truncate();
    $tasks = DB::table('tasks')->get();
    $this->assertEquals(0, sizeof($tasks));

    DB::table('users')->truncate();
    DB::table('users')
      ->insert(['name' => 'guber', 'email' =>'emanuel.guberovic@fer.hr', 'password' => bcrypt('jakasifra')]);
    $users = DB::table('users')->get();
    $this->assertEquals(1, sizeof($users));
  }

  public function testMethodsOnCollection()
  {
    $user = User::find(1);
    $response = $this->actingAs($user)->call('OPTIONS', 'tasks/');
    $this->assertEquals(200, $response->status());
    $response = $this->actingAs($user)->call('HEAD', 'tasks/');
    $this->assertEquals(200, $response->status());
    $response = $this->actingAs($user)->call('POST', 'tasks/');
    $this->assertEquals(200, $response->status());
  }

  public function testPost()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('POST', '/tasks', ['name' => 'Razviti test caseve', 'description' => 'Razviti test caseve za naš prvi REST sustav.',
      'status' => 'gotovo', 'user_id' => '1', 'project_id' => '1'])
      ->seeJSON([
        'created' => true,
      ]);
  }

  public function testPostNoParametars()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('POST', '/tasks', [])
      ->seeJSON([
        'created' => false,
      ]);
  }

  public function testGetExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->call('GET', 'tasks/');
    $this->assertEquals(200, $response->status());

    $this->json('GET', '/tasks/1', [])
      ->seeJSON(["id" => 1, "user_id" => 1, "name" => "Razviti test caseve",
        "description" => "Razviti test caseve za naš prvi REST sustav.", "status" => "gotovo"]);
  }

  public function testGetNonExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->actingAs($user)->call('GET', '/tasks/2');
    $this->assertEquals(404, $response->status());
  }

  public function testPutExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('POST', '/tasks', ['name' => 'Prema test casevima razviti servise', 'description' => 'Razviti servise prema test casevima.',
      'status' => 'prihvaćeno', 'user_id' => '1', 'project_id' => '1']);
    $this->json('PUT', '/tasks/2', ['name' => 'Razviti test caseve', 'description' => 'Razviti test caseve za naš prvi REST sustav.',
      'status' => 'gotovo', 'user_id' => '1', 'project_id' => '1'])
      ->seeJSON([
        'updated' => true,
      ]);

    $this->json('PUT', '/tasks/2', ['name' => 'Razviti test caseve', 'description' => 'Razviti test caseve za naš prvi REST sustav.',
      'status' => 'gotovo', 'user_id' => '1', 'project_id' => '1'])
      ->seeJSON([
        'updated' => false,
      ]);

  }

  public function testDeleteExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('Delete', '/tasks/2', ['name' => 'Prema test casevima razviti servise', 'description' => 'Razviti servise prema test casevima.',
      'status' => 'prihvaćeno', 'user_id' => '1', 'project_id' => '1'])
      ->seeJSON([
        'deleted' => true,
      ]);
  }

  public function testDeleteNonExiting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->actingAs($user)->call('DELETE', '/tasks/2');
    $this->assertEquals(404, $response->status());
  }
}
