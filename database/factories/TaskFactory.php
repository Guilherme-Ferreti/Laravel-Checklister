<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'checklist_id' => Checklist::factory()->create(),
            'name' => $this->faker->text(rand(5, 50)),
            'description' => $this->faker->paragraphs(3, true),
            'position' => Task::max('position') + 1,
        ];
    }
}
