<?php

use app\Controllers\WorkoutController;
use app\Support\Session;

include "components/head.php";

if (!Session::isUserLoggedIn()) {
    header("Location: /workout-logger/register");
}
$workoutController = new WorkoutController();
$workoutPlans = $workoutController->getAllWorkoutPlans();
?>

<main class="mt-5">
    <div class="container">
        <div class="row">
            <?php foreach ($workoutPlans as $workoutPlan) : ?>
                <div class="col-md-4">
                    <div class="workoutCard">
                        <h2><?= $workoutPlan['plan_name'] ?></h2>
                        <p><?= $workoutPlan['description'] ?></p>
                        <a href="/workout-logger/workout-plan?workout_plan_id=<?= $workoutPlan['id'] ?>" class="btn mb-3">Go To Workout</a>
                        <form action="/workout-logger/workout-plan/remove" method="POST">
                            <input type="hidden" name="workoutPlanId" id="workoutPlanId" value="<?= $workoutPlan['id'] ?>">
                            <button type="submit" class="btn-remove">Remove Workout Plan</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include 'components/footer.php' ?>