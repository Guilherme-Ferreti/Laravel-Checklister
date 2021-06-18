<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompletedTasksCounter extends Component
{
    public $completed_tasks = 0;
    public $tasks_count = 0;
    public $checklist_id;

    public $listeners = ['task_complete' => 'recalculate_tasks'];

    public function render()
    {
        return view('livewire.completed-tasks-counter');
    }

    public function recalculate_tasks(int $task_id, int $checklist_id, $count_change = 1)
    {
        if ($this->checklist_id == $checklist_id) {
            $this->completed_tasks+= $count_change;
        }
    }
}
