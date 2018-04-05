<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\User;
use App\Http\Controllers\UsersController as UserControl;
use Illuminate\Support\Facades\DB;
use JWTAuth;

class UserTest extends TestCase
{
    protected $user;

  public function setUp()
  {
    parent::setUp();

    $users = new User();
    $this->user = $users;
    // User::truncate();
  }

  /** @test */
  public function add_a_user()
  {
    $createdStatus = 201;
    $createdResponse = 'Successfully added user';

    // $user = DB::select('select * from users where id = 1');
    // dd($user[0]->email);
    $data = [
      'username' => '0958982073',
      'password' => 'secret'
    ];

    $post = $this->post('/api/auth/login', $data);
    dd($post->getContent());
    // generateNewUser(5, 'make');
    $firstUser = User::first();
    $token = JWTAuth::fromUser($firstUser);
    $header = [ 'Authorization' => 'Bearer '. $token ];
    $newUser = generateNewUser(null, 'make');
    // dd($newUser);
    $post = $this->post('/api/user', $newUser, $header);

    // dd($post->getContent());
    $post->assertStatus($createdStatus);
    
    $stringResponse = is_string($post->getContent());
    $this->assertTrue($stringResponse);

    $jsonReponseContent = $post->getContent();
    $result = json_decode($jsonReponseContent);
    // dd($result);
    // $this->assertEquals($createdResponse, $result);
    $this->assertObjectHasAttribute('user_id', $result->data);
    $this->assertNull($result->error);


    // dd($jsonReponseContent);
    // $this->assertObjectHasAttribute('username', $jsonReponseContent);
    // $this->assertObjectHasAttribute('id', $jsonReponseContent);
  }
}
