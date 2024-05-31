<?php

use app\Controllers\WorkoutController;
include "components/head.php";

$workoutController = new WorkoutController();
$workoutDays = $workoutController->getWorkoutDayByWorkoutPlanId($_GET['workout_plan_id']);
?>

<main class="container mt-4 pb-100">
    <h2 class="fw-semibold"><?= $workoutPlan['plan_name'] ?></h2>
    <p><?= $workoutPlan['description'] ?></p>
    <?php if ($workoutDays) : ?>
        <div class="row my-5">
            <?php foreach ($workoutDays as $workoutDay) : ?>
                    <div class="col-md-4">
                        <div class="workoutCard">
                            <h4 class="mb-4"><span class="workoutDayTitle"><?= $workoutDay['title'] ?></span></h4>
                            <form action="/workout-logger/workout-day/edit" method="POST" class="d-none">
                                <div class="d-flex mb-3">
                                    <input type="text" name="workoutDayTitle" id="workoutDayTitle" class="styledInput mb-0 me-3">
                                    <button type="submit" class="btn w-30">Submit</button>
                                </div>
                                <input type="hidden" name="workoutPlanId" value="<?= $_GET['workout_plan_id'] ?>">
                                <input type="hidden" name="workoutDayId" value="<?= $workoutDay['id'] ?>">
                            </form>
                            <a href="/workout-logger/workout-day?workout_day_id=<?= $workoutDay['id'] ?>" class="btn mb-2">Go to Workout</a>
                            <button class="editWorkoutDayTitle btn-success mb-2">Edit</button>
                            <form action="/workout-logger/workout-day/remove" method="POST" onsubmit="return confirmSubmit('Are you sure you want to remove this workout day?')">
                                <input type="hidden" name="workoutDayId" id="workoutDayId" value="<?= $workoutDay['id'] ?>">
                                <input type="hidden" name="workoutPlanId" id="workoutPlanId" value="<?= $workoutPlan['id'] ?>">
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </div>
                    </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h4 class="mb-3">Add a workout day</h4>
    <div class="row">
        <div class="col-md-4">
            <form class="addWorkoutDayForm" action="/workout-logger/workout-day/submit" method="POST">
                <label for="title" class="d-block mb-2">Day Name</label>
                <div class="d-flex">
                    <input type="text" name="title" id="title" class="styledInput mb-0 me-2">
                    <input type="hidden" value="<?= $workoutPlan['id'] ?>" name="workout_plan_id" id="workout_plan_id">
                    <button type="submit" class="btn w-30">Submit</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'components/footer.php' ?>