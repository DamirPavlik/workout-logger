<?php


use app\Controllers\WorkoutController;

include "components/head.php";

$workoutDayId = $_GET['workout_day_id'];
$workoutController = new WorkoutController();
$workoutDay = $workoutController->getWorkoutDayById($workoutDayId);
$exercises = $workoutController->getExercisesByWorkoutDayId($workoutDayId);

$userHitAPr = $_SESSION['userPR'] ?? null;
unset($_SESSION["userPR"]);

echo $userHitAPr;
?>
<main class="mt-5 pb-100 workoutDayWrapper">
    <div class="container">
        <div class="row mb-5">
            <?php foreach ($exercises as $exercise) : ?>
                <?php $logs = $workoutController->getAllLogsByExerciseId($exercise['id']); ?>
                <div class="col-md-4">
                    <div class="workoutCard">
                        <h2 class="exerciseTitle"><?= $exercise['title']; ?></h2>
                        <form action="/workout-logger/exercise/edit" method="POST" class="d-none">
                            <div class="d-flex mb-3">
                                <input type="text" name="exerciseTitle" id="exerciseTitle" class="styledInput mb-0 me-3">
                                <button type="submit" class="btn w-30">Submit</button>
                            </div>
                            <input type="hidden" name="exerciseId" value="<?= $exercise['id'] ?>">
                            <input type="hidden" name="workoutDayId" value="<?= $workoutDayId ?>">
                        </form>
                         <p><?= $exercise['description'] ?></p>
                        <dialog class="logDialog">
                            <div class="text-end">
                                <button autofocus class="closeButton">X</button>
                            </div>
                            <table>
                                <tr>
                                    <th>Sets</th>
                                    <th>Reps</th>
                                    <th>Weight</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                <?php foreach ($logs as $log) : ?>
                                    <tr>
                                        <td class="logSets"><?= $log['sets']; ?></td>
                                        <td class="logReps"><?= $log['reps'] ?></td>
                                        <td class="logWeight"><?= $log['weight'] ?> kg</td>
                                        <td class="logDate"><?= $log['created_at'] ?></td>
                                        <td class="d-flex">
                                            <form action="/workout-logger/logs/remove" method="POST">
                                                <input type="hidden" name="logId" id="logId" value="<?= $log['id'] ?>">
                                                <input type="hidden" name="workoutDayId" id="workoutDayId" value="<?= $workoutDayId ?>">
                                                <button class="deleteLog btn btn-remove me-2">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </dialog>
                        <button class="showDialog btn mb-2">See Logs</button>
                        <form action="/workout-logger/exercise/remove" class="mb-2" method="POST" onsubmit="return confirmSubmit('Are you sure you want to remove this exercise?')">
                            <input type="hidden" name="exerciseId" id="exerciseId" value="<?= $exercise['id'] ?>">
                            <input type="hidden" name="workoutDayId" id="workoutDayId" value="<?= $workoutDayId ?>">
                            <button type="submit" class="btn-remove">Remove</button>
                        </form>
                        <button class="btn-success editExercise">Edit</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="/workout-logger/exercise/submit" method="POST">
                    <div>
                        <label for="exerciseName" class="mb-1">Exercise Name</label>
                        <input type="text" name="exerciseName" id="exerciseName" class="styledInput">
                    </div>
                    <div>
                        <label for="exerciseDescription" class="mb-1">Description</label>
                        <textarea name="exerciseDescription" id="exerciseDescription" cols="30" rows="10" class="styledInput noResize"></textarea>
                    </div>
                    <input type="hidden" value="<?= $workoutDayId ?>" name="workoutDayId" id="workoutDayId" >
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <?php if ($exercises) : ?>
                <form action="/workout-logger/logs/submit" method="POST">
                    <div>
                        <label for="sets" class="mb-1">Sets</label>
                        <input type="number" name="sets" id="sets" class="styledInput">
                    </div>

                    <div>
                        <label for="reps" class="mb-1">Reps - Comma Separated Values</label>
                        <input type="text" name="reps" id="reps" class="styledInput">
                    </div>

                    <div>
                        <label for="weight" class="mb-1">Weight</label>
                        <input type="text" name="weight" id="weight" class="styledInput">
                    </div>

                    <div>
                        <label for="exercise" class="mb-1">Exercise</label>
                        <select name="exercise" id="exercise" class="styledInput exerciseSelect">
                            <option value="disabled" disabled selected>Select an Exercise</option>
                            <?php foreach ($exercises as $exercise) : ?>
                                <option value="<?= $exercise['id'] ?>"><?= $exercise['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="styledInput colorSchemeDark">
                    </div>
                    <input type="hidden" name="exerciseId" id="exerciseId" class="hiddenExerciseId">
                    <input type="hidden" name="workoutDayId" id="workoutDayId" value="<?= $_GET['workout_day_id'] ?>">
                    <button type="submit" class="btn mt-2">Submit</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

    <script>
        let exerciseSelect = document.querySelector('.exerciseSelect');
        let exerciseInput = document.querySelector('.hiddenExerciseId');
        exerciseSelect.addEventListener("change", (e) => {
            exerciseInput.value = e.target.value;
        })
    </script>

<?php include 'components/footer.php' ?>