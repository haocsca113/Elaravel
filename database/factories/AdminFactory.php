<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;
use App\Models\Roles;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_name' => fake()->name(),
            'admin_email' => fake()->unique()->safeEmail(),
            'admin_phone' => '0988820943',   
            'admin_password' => '25f9e794323b453885f5181f1b624d0b',
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Admin $admin) {
            $roles = Roles::where('name', 'user')->pluck('id_roles');
            $admin->roles()->sync($roles);
        });
    }
}
