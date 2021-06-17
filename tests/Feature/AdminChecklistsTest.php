<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ChecklistGroup;
use App\Services\SidebarService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminChecklistsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $admin = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($admin)->post(route('admin.checklist_groups.store'), [
            'name' => 'First group',
        ]);
        $response->assertRedirect(route('welcome'));
        
        $group = ChecklistGroup::where('name', 'First group')->first();
        $this->assertNotNull($group);
        
        $response = $this->actingAs($admin)->get(route('admin.checklist_groups.edit', [$group]));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put(route('admin.checklist_groups.update', [$group]), [
            'name' => 'First group updated',
        ]);
        $response->assertRedirect(route('welcome'));

        $group = ChecklistGroup::where('name', 'First group updated')->first();
        $this->assertNotNull($group);

        $sidebar = (new SidebarService())->get_sidebar();
        $this->assertEquals(1, $sidebar['admin_menu']->where('name', 'First group updated')->count());

        dd($sidebar['user_menu']);
    }
}
