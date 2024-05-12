<?php

namespace app\Models;

use app\Repositories\WorkoutRepo;

readonly class WorkoutModel
{

    public function __construct(private WorkoutRepo $workoutRepo = new WorkoutRepo()) {}

    public function addWorkoutPlan(array $formData): void
    {
        $this->workoutRepo->insertWorkoutPlan(formData: $formData);
    }

    public function addWorkoutDay(array $formData): void
    {
        $this->workoutRepo->insertWorkoutDay($formData);
    }

    public function addExercise(array $formData): void
    {
        $this->workoutRepo->insertExercise(formData: $formData);
    }
}