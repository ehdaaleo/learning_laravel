<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_index_displays_seeded_post_content(): void
    {
        $post = Post::factory()->create([
            'title' => 'Laravel Lab Post',
            'description' => 'Testing the posts index page.',
        ]);

        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertSee($post->title);
    }

    public function test_soft_deleted_post_can_be_restored(): void
    {
        $post = Post::factory()->create();
        $post->delete();

        $this->post(route('posts.restore', $post->id))
            ->assertRedirect(route('posts.trashed'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'deleted_at' => null,
        ]);
    }
}
