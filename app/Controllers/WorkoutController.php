<?php

namespace app\Controllers;

use app\Models\WorkoutModel;
use app\Repositories\WorkoutRepo;

class WorkoutController extends BaseController
{
    public function __construct(
        private readonly WorkoutModel $workoutModel = new WorkoutModel(),
        private readonly WorkoutRepo $workoutRepo = new WorkoutRepo()
    ) {}

    public function handleAddWorkoutPlan(array $params = []): void
    {
        if (empty($params['title'])) {
            $_SESSION['workoutPlanErrors'] = "Title can not be empty";
            $this->redirect('/workout');
        }
        $this->workoutModel->addWorkoutPlan(formData: $params);
        // get the id and redirect to that id
        $this->redirect(path: '/');
    }

    public function getAllWorkoutPlans(): array
    {
        return $this->workoutRepo->getAllWorkoutByUserId();
    }

    public function permalinkWorkoutPlan(array $params = []): void
    {
        if (!isset($params['workout_plan_id'])) $this->redirectToNotFound();
        if (!is_numeric($params['workout_plan_id'])) $this->redirectToNotFound();

        $workoutPlan = $this->workoutRepo->getWorkoutPlanById($params['workout_plan_id']);

        if (!isset($workoutPlan)) $this->redirectToNotFound();

        require_once __DIR__ . '/../../view/workoutPlan.php';
    }

    public function permalinkWorkoutDay(array $params = []): void
    {
        if (!isset($params['workout_day_id'])) $this->redirectToNotFound();
        if (!is_numeric($params['workout_day_id'])) $this->redirectToNotFound();

        $workoutPlan = $this->workoutRepo->getWorkoutDayById($params['workout_day_id']);

        if (!isset($workoutPlan)) $this->redirectToNotFound();

        require_once __DIR__ . '/../../view/workoutDay.php';
    }

    public function handleAddWorkoutDay(array $params = []): void
    {
        if (empty($params['title'])) {
            $_SESSION['workoutDayErrors'] = 'Title can not be empty';
            $this->redirect(path: '/workout-plan?workout_plan_id=' . $params['workout_plan_id']);
        }
        $this->workoutModel->addWorkoutDay(formData: $params);
        $this->redirect(path: '/workout-plan?workout_plan_id=' . $params['workout_plan_id']);
    }

    public function getWorkoutDayByWorkoutPlanId(int $workoutPlanId): array
    {
        return $this->workoutRepo->getWorkoutDayByWorkoutPlanId(workoutPlanId: $workoutPlanId);
    }

    public function handleAddExercise(array $params = []): void
    {
        if (empty($params['exerciseName'])) {
            $_SESSION['exerciseErrors'] = 'Title can not be empty';
            $this->redirect(path: '/workout-day?workout_day_id=' . $params['workoutDayId']);
        }

        $this->workoutModel->addExercise(formData: $params);
        $this->redirect(path: '/workout-day?workout_day_id=' . $params['workoutDayId']);
    }

    public function handleRemoveWorkoutDay(array $params = []): void
    {
        $this->workoutRepo->removeWorkoutDay(workoutDayId: $params['workoutDayId']);
        $this->redirect(path: '/workout-plan?workout_plan_id=' . $params['workoutPlanId']);
    }

    public function handleRemoveWorkoutPlan(array $formData): void
    {
        $this->workoutRepo->removeWorkoutPlan(workoutPlanId: $formData['workoutPlanId']);
        $this->redirect(path: "/");
    }

    public function getExercisesByWorkoutDayId(int $workoutDayId): array
    {
        return $this->workoutRepo->getExercisesByWorkoutDayId($workoutDayId);
    }

    public function getWorkoutDayById(int $workoutDayId): array
    {
        return $this->workoutRepo->getWorkoutDayById($workoutDayId);
    }

    public function handleAddLog(array $params = []): void
    {
        $this->workoutRepo->insertLog($params);

        $hasUserHitAPr = $this->workoutModel->hasUserHitAPR($params);
        if ($hasUserHitAPr) {
            $_SESSION['userPR'] = "You hit a pr";
        }

        $this->redirect('/workout-day?workout_day_id=' . $params['workoutDayId']);
    }

    public function getAllLogsByExerciseId(int $exerciseId): array
    {
        return $this->workoutRepo->getAllLogsByExerciseId($exerciseId);
    }

    public function handleEditWorkoutDay(array $params = []): void
    {
        if (empty($params['workoutDayTitle'])) {
            $_SESSION['editWorkoutDayErrors'] = 'Title can not be empty';
            $this->redirect('/workout-plan?workout_plan_id=' . $params['workoutPlanId']);
        }
        $this->workoutRepo->editWorkoutDayTitle(formData: $params);
        $this->redirect('/workout-plan?workout_plan_id=' . $params['workoutPlanId']);
    }

    public function handleEditExercise(array $params = []): void
    {
        $this->workoutRepo->editExercise(formData: $params);
        $this->redirect(path: "/workout-day?workout_day_id=" . $params['workoutDayId']);
    }

    public function handleRemoveLog(array $formData): void
    {
        $this->workoutRepo->removeLogById(logId: $formData['logId']);
        $this->redirect(path: "/workout-day?workout_day_id=" . $formData['workoutDayId']);
    }

    public function handleRemoveExercise(array $formData): void
    {
        $this->workoutRepo->removeExercise(exerciseId: $formData['exerciseId']);
        $this->redirect(path: "/workout-day?workout_day_id=" . $formData['workoutDayId']);
    }
}