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

    public function hasUserHitAPR(array $formData): bool
    {
        $results = $this->workoutRepo->getLogByExerciseId($formData['exerciseId']);

        if (empty($results)) {
            return false;
        }

        $latestResult = array_reduce(
            array: $results, callback:
            fn($carry, $item) => (!$carry || strtotime($item['date']) > strtotime($carry['created_at'])) ? $item : $carry
        );

        $repsFromFormData = array_map(callback: 'trim', array: explode(separator: ',', string: $formData['reps']));
        $repsFromResults = array_map(callback: 'trim', array: explode(separator: ',', string: $latestResult['reps']));

        if (count($repsFromResults) !== count($repsFromFormData)) {
            return false;
        }

        if ($latestResult['weight'] === $formData['weight']) {
            foreach ($repsFromFormData as $index => $rep) {
                if ($rep > $repsFromResults[$index]) {
                    return true;
                }
            }
        }

        if ($latestResult['weight'] < $formData['weight']) {
            return true;
        }

        return false;
    }
}