<?php

namespace Tests\Feature;

use App\Http\Livewire\TasksTable;
use Tests\TestCase;
use App\Models\User;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use App\Models\Task;
use App\Services\SidebarService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class AdminChecklistsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $admin = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($admin);
    }

    public function test_manage_checklist_groups()
    {
        $prefix = 'admin.checklist_groups';

        // Test CREATING the checklist group
        $response = $this->post(route("$prefix.store"), [
            'name' => 'First group',
        ]);
        $response->assertRedirect(route('welcome'));
        
        $group = ChecklistGroup::where('name', 'First group')->first();
        $this->assertNotNull($group);
        
        // Test EDITING the checklist group
        $response = $this->get(route("$prefix.edit", [$group]));
        $response->assertStatus(200);

        $response = $this->put(route("$prefix.update", [$group]), [
            'name' => 'First group updated',
        ]);
        $response->assertRedirect(route('welcome'));

        $group = ChecklistGroup::where('name', 'First group updated')->first();
        $this->assertNotNull($group);

        // Test ADMIN MENU
        $sidebar = (new SidebarService())->get_sidebar();
        $this->assertEquals(1, $sidebar['admin_menu']->where('name', 'First group updated')->count());

        // Test DELETING the checklist group
        $response = $this->delete(route("$prefix.destroy", [$group]));
        $response->assertRedirect(route('welcome'));

        $group = ChecklistGroup::where('name', 'First group updated')->first();
        $this->assertNull($group);
    }

    public function test_manage_checklists()
    {
        $checklistGroup = ChecklistGroup::factory()->create();

        $prefix = 'admin.checklist_groups.checklists';

        // Test CREATING the checklist
        $response = $this->post(route("$prefix.store", [$checklistGroup]), [
            'name' => 'My Checklist',
        ]);
        $response->assertRedirect(route('welcome'));

        $checklist = Checklist::where('name', 'My Checklist')->first();
        $this->assertNotNull($checklist);

        // Test EDITING the checklist
        $response = $this->get(route("$prefix.edit", [$checklistGroup, $checklist]));
        $response->assertStatus(200);

        $response = $this->put(route("$prefix.update", [$checklistGroup, $checklist]), [
            'name' => 'My Checklist Update',
        ]);
        $response->assertRedirect(route('welcome'));

        $checklist = Checklist::where('name', 'My Checklist Update')->first();
        $this->assertNotNull($checklist);

        $sidebar = (new SidebarService())->get_sidebar();
        $this->assertTrue($sidebar['admin_menu']->first()->checklists->contains($checklist));

        // Test DELETING the checklist
        $response = $this->delete(route("$prefix.destroy", [$checklistGroup, $checklist]));
        $response->assertRedirect(route('welcome'));

        $checklist = Checklist::where('name', 'My Checklist Update')->first();
        $this->assertNull($checklist);

        $sidebar = (new SidebarService())->get_sidebar();
        $this->assertFalse($sidebar['admin_menu']->first()->checklists->contains($checklist));
    }

    public function test_manage_tasks()
    {
        $checklistGroup = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklistGroup]);
        
        $prefix = 'admin.checklists.tasks';

        // Test CREATING the task
        $response = $this->post(route("$prefix.store", [$checklist]), [
            'name' => 'Some name',
            'description' => 'Some description',
        ]);
        $response->assertRedirect(route('admin.checklist_groups.checklists.edit', [$checklistGroup, $checklist]));

        $task = Task::where('name', 'Some name')->first();
        $this->assertNotNull($task);
        $this->assertEquals(1, $task->position);

        // Test EDITING the task
        $response = $this->get(route("$prefix.edit", [$checklist, $task]));
        $response->assertStatus(200);

        $response = $this->put(route("$prefix.update", [$checklist, $task]), [
            'name' => 'Some name updated',
            'description' => 'Some description updated',
        ]);
        $response->assertRedirect(route('admin.checklist_groups.checklists.edit', [$checklistGroup, $checklist]));

        $task = Task::where('name', 'Some name updated')->first();
        $this->assertNotNull($task);
    }

    public function test_delete_task_with_position_reordered()
    {
        $checklistGroup = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklistGroup]);

        $task1 = Task::factory()->create(['checklist_id' => $checklist, 'position' => 1]);
        $task2 = Task::factory()->create(['checklist_id' => $checklist, 'position' => 2]);

        $response = $this->delete(route('admin.checklists.tasks.destroy', [$checklist, $task1]));
        $response->assertRedirect(route('admin.checklist_groups.checklists.edit', [$checklistGroup, $checklist]));

        $task = Task::find($task1->id);
        $this->assertNull($task);

        $task = Task::find($task2->id);
        $this->assertEquals(1, $task->position);
    }

    public function test_reordering_task_with_livewire()
    {
        $checklistGroup = ChecklistGroup::factory()->create();
        $checklist = Checklist::factory()->create(['checklist_group_id' => $checklistGroup]);

        $task1 = Task::factory()->create(['checklist_id' => $checklist, 'position' => 1]);
        $task2 = Task::factory()->create(['checklist_id' => $checklist, 'position' => 2]);

        Livewire::test(TasksTable::class, ['checklist' => $checklist])
            ->call('task_up', $task2->id);

        $task = Task::find($task2->id);
        $this->assertEquals(1, $task->position);

        Livewire::test(TasksTable::class, ['checklist' => $checklist])
        ->call('task_down', $task2->id);

        $task = Task::find($task2->id);
        $this->assertEquals(2, $task->position);
    }
}
