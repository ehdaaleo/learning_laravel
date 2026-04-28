<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GithubAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_authenticate_with_github_callback(): void
    {
        $provider = Mockery::mock(Provider::class);
        $socialiteUser = new SocialiteUser();
        $socialiteUser->id = 12345;
        $socialiteUser->name = 'GitHub Tester';
        $socialiteUser->nickname = 'ghtester';
        $socialiteUser->email = 'github@example.com';
        $socialiteUser->token = 'token-value';
        $socialiteUser->refreshToken = 'refresh-token-value';

        $provider->shouldReceive('user')
            ->once()
            ->andReturn($socialiteUser);

        $factory = Mockery::mock(SocialiteFactory::class);
        $factory->shouldReceive('driver')
            ->once()
            ->with('github')
            ->andReturn($provider);

        $this->app->instance(SocialiteFactory::class, $factory);

        $response = $this->get(route('github.callback'));

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'github@example.com',
            'github_id' => '12345',
        ]);
    }
}
