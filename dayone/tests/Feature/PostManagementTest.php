<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $admin = User::factory()->admin()->create();
        $post = Post::factory()->create();
        $post->delete();

        $this->actingAs($admin)
            ->post(route('posts.restore', $post->id))
            ->assertRedirect(route('posts.trashed'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'deleted_at' => null,
        ]);
    }

    public function test_post_image_is_replaced_and_old_file_is_deleted_on_update(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $oldImage = UploadedFile::fake()->image('old.jpg');
        $newImage = UploadedFile::fake()->image('new.png');

        $post = Post::factory()->for($user)->create([
            'image' => $oldImage->store('posts', 'public'),
        ]);

        $this->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'Updated title',
                'description' => 'Updated description for the post body.',
                'image' => $newImage,
                'tags' => 'laravel,backend',
            ])
            ->assertRedirect(route('posts.show', $post));

        Storage::disk('public')->assertMissing($post->getRawOriginal('image'));
        Storage::disk('public')->assertExists($post->fresh()->image);
    }

    public function test_post_image_is_deleted_when_post_is_deleted(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $uploadedImage = UploadedFile::fake()->image('post.jpg');
        $imagePath = $uploadedImage->store('posts', 'public');

        $post = Post::factory()->for($user)->create([
            'image' => $imagePath,
        ]);

        $this->actingAs($user)
            ->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        Storage::disk('public')->assertMissing($imagePath);
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_user_cannot_edit_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->for($owner)->create();

        $this->actingAs($otherUser)
            ->get(route('posts.edit', $post))
            ->assertForbidden();
    }

    public function test_non_admin_user_cannot_access_trashed_posts_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('posts.trashed'))
            ->assertForbidden();
    }
}
