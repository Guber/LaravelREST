<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{


  public function testTableEmpty()
  {
    DB::table('projects')->truncate();
    $projects = DB::table('projects')->get();
    $this->assertEquals(0, sizeof($projects));

    DB::table('users')->truncate();
    DB::table('users')
      ->insert(['name' => 'guber', 'email' =>'emanuel.guberovic@fer.hr', 'password' => bcrypt('jakasifra')]);
    $users = DB::table('users')->get();
    $this->assertEquals(1, sizeof($users));

    DB::table('tasks')->truncate();
    DB::table('tasks')
      ->insert(['name' => 'Prvi task', 'description' =>'opid prvog taska', 'user_id' => '1', 'project_id' => '1',
        'status' => 'prihvaceno']);
    $tasks = DB::table('tasks')->get();
    $this->assertEquals(1, sizeof($tasks));
  }

  public function testMethodsOnCollection()
  {
    $user = User::find(1);
    $response = $this->actingAs($user)->call('OPTIONS', 'users/');
    $this->assertEquals(200, $response->status());
    $response = $this->actingAs($user)->call('HEAD', 'users/');
    $this->assertEquals(200, $response->status());
    $response = $this->actingAs($user)->call('POST', 'users/');
    $this->assertEquals(200, $response->status());
  }

  public function testPost()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('POST', '/users', ['name' => 'korisnik', 'email' => 'email@neki.com', 'password' => bcrypt('jakasifra')])
      ->seeJSON([
        'created' => true,
      ]);
  }

  public function testPostNoParametars()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('POST', '/users', [])
      ->seeJSON([
        'created' => false,
      ]);
  }

  public function testGetExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->call('GET', 'users/');
    $this->assertEquals(200, $response->status());

    $this->json('GET', '/users/2', [])
      ->seeJSON(["id" => 2, 'name' => 'korisnik', 'email' => 'email@neki.com']);
  }

  public function testGetExistingTasks()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->call('GET', 'users/1/tasks');
    $this->assertEquals(200, $response->status());
  }

  public function testGetNonExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->actingAs($user)->call('GET', '/users/900');
    $this->assertEquals(404, $response->status());
  }

  public function testPutExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('PUT', '/users/2', ['name' => 'korisnik2', 'email' => 'email@neki.com', 'password' => bcrypt('jakasifra')])
      ->seeJSON([
        'updated' => true,
      ]);
  }

  public function testDeleteExisting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $this->json('DELETE', '/users/2')
      ->seeJSON([
        'deleted' => true,
      ]);
  }

  public function testDeleteNonExiting()
  {
    $user = User::find(1);
    $this->be($user); //You are now authenticated

    $response = $this->actingAs($user)->call('DELETE', '/users/2');
    $this->assertEquals(404, $response->status());
  }
}
