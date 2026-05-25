<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WhiteboardAction;
use App\Models\WhiteboardUser;
use App\Models\ChatMessage;
use Tests\TestCase;

class WorkspaceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Since database setup uses MongoDB, clean the collections we use before each test if using real DB
        if (config('database.default') === 'mongodb' || config('database.connections.mongodb.database') !== ':memory:') {
            WhiteboardAction::truncate();
            WhiteboardUser::truncate();
            ChatMessage::truncate();
        }
    }

    public function test_unauthenticated_user_cannot_access_workspace()
    {
        $response = $this->get('/workspace');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_workspace()
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/workspace');
        $response->assertStatus(200);
        $response->assertViewIs('workspace');
        $response->assertViewHas('user');
    }

    public function test_workspace_sync_updates_cursor_and_retrieves_actions()
    {
        $user = User::first() ?? User::factory()->create();

        // 1. Create a mock external whiteboard action
        $externalAction = WhiteboardAction::create([
            'user_id' => 'external_user_123',
            'username' => 'External User',
            'color' => '#ff0000',
            'type' => 'stroke',
            'points' => [['x' => 100, 'y' => 200], ['x' => 150, 'y' => 250]],
            'size' => 6,
            'created_at_ms' => round(microtime(true) * 1000) - 100, // created in the past
        ]);

        // 2. Perform sync request as current user
        $response = $this->actingAs($user)->postJson('/workspace/sync', [
            'last_sync' => round(microtime(true) * 1000) - 500, // sync since 500ms ago
            'cursor' => ['x' => 0.45, 'y' => 0.55],
            'actions' => [
                [
                    'type' => 'rectangle',
                    'color' => '#00ff00',
                    'size' => 2,
                    'points' => [['x' => 10, 'y' => 20], ['x' => 30, 'y' => 40]],
                    'created_at_ms' => round(microtime(true) * 1000)
                ]
            ],
            'chat_message' => 'Hello team!'
        ]);

        $response->assertStatus(200);
        $data = $response->json();

        // Verify response contains the external action
        $this->assertNotEmpty($data['actions']);
        $this->assertEquals('external_user_123', $data['actions'][0]['user_id']);

        // Verify response contains chat messages
        $this->assertNotEmpty($data['chat_messages']);
        $this->assertEquals('Hello team!', $data['chat_messages'][0]['message']);

        // Verify active user was saved in db
        $activeUserObj = WhiteboardUser::where('user_id', $user->id)->first();
        $this->assertNotNull($activeUserObj);
        $this->assertEquals(0.45, $activeUserObj->x);
        $this->assertEquals(0.55, $activeUserObj->y);
    }

    public function test_workspace_clear_clears_actions_and_records_clear_event()
    {
        $user = User::first() ?? User::factory()->create();

        // Seed some actions
        WhiteboardAction::create([
            'user_id' => $user->id,
            'type' => 'stroke',
            'created_at_ms' => 100
        ]);

        $response = $this->actingAs($user)->postJson('/workspace/clear');
        $response->assertStatus(200);

        // All existing actions should be cleared, but a new "clear" event should be added
        $actions = WhiteboardAction::all();
        $this->assertCount(1, $actions);
        $this->assertEquals('clear', $actions[0]->type);
    }
}
