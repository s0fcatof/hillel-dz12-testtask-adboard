<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_seeAdOnHomepage()
    {
        $ad = Ad::factory()->create();

        $response = $this->get('/');

        $response->assertSee([$ad->title, $ad->description, $ad->author->username]);
        $response->assertDontSee('qwertyuiop');
    }

    public function test_ShowAd()
    {
        $ad = Ad::factory()->create();

        $response = $this->get('/' . $ad->id);

        $response->assertSee([$ad->title, $ad->description, $ad->author->username, $ad->created_at]);
        $response->assertDontSee('qwertyuiop');
    }

    public function test_ShowNonexistentAd()
    {
        $ad = Ad::factory()->create();

        $response = $this->get('/' . $ad->id+1);

        $response->assertNotFound();
    }

    public function test_getLogin()
    {
        $response = $this->get('/login');

        $response->assertRedirect('/');
    }

    public function test_EmptyAuthForm()
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['username', 'password']);
    }

    public function test_EmptyAuthUsernameField()
    {
        $response = $this->post('/login', ['password' => 'password']);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_EmptyAuthPasswordField()
    {
        $response = $this->post('/login', ['username' => 'username']);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_SignUp()
    {
        $user = User::factory()->make();

        $attributes = [
            'username' => $user->username,
            'password' => 'password'
        ];

        $response = $this->post('/login', $attributes);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['username' => $user->username]);

        $response = $this->get('/');
        $response->assertSeeText('Hello, ' . $user->username . '!');
        $this->assertAuthenticated();
    }

    public function test_LogIn()
    {
        $user = User::factory()->create();

        $attributes = [
            'username' => $user->username,
            'password' => 'password'
        ];

        $response = $this->post('/login', $attributes);
        $response->assertRedirect('/');

        $response = $this->get('/');
        $response->assertSeeText('Hello, ' . $user->username . '!');
        $this->assertAuthenticated();
    }

    public function test_LogInFailed()
    {
        $user = User::factory()->create();

        $attributes = [
            'username' => $user->username,
            'password' => 'qwerty'
        ];

        $response = $this->post('/login', $attributes);
        $response->assertRedirect('/');

        $response = $this->get('/');
        $response->assertDontSeeText('Hello, ' . $user->username . '!');
        $this->assertGuest();
    }

    public function test_LogOutAsUnauthenticatedUser()
    {
        $response = $this->get('/logout');

        $response->assertRedirect('/login');
    }

    public function test_LogOutAsAuthenticatedUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_CreateAdAsUnauthenticatedUser()
    {
        $response = $this->get('/edit');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_CreateAdAsAuthenticatedUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/edit');

        $response->assertOk();
    }

    public function test_EditAdAsUnauthorizedUser()
    {
        $user = User::factory()->hasAds(1)->create();
        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->get('/edit/' . $user->ads->first()->id);
        $response->assertForbidden();
    }

    public function test_EditAdAsUnauthenticatedUser()
    {
        $user = User::factory()->hasAds(1)->create();

        $response = $this->get('/edit/' . $user->ads->first()->id);
        $response->assertForbidden();
    }

    public function test_EditAdAsAuthorizedUser()
    {
        $user = User::factory()->hasAds(1)->create();

        $response = $this->actingAs($user)->get('/edit/' . $user->ads->first()->id);

        $response->assertOk();
    }
}
