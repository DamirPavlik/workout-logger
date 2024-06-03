<?php

namespace app\Repositories;

class WorkoutRepo extends BaseRepository
{
    public function insertWorkoutPlan(array $formData): void
    {
        $title = $this->sanitizeInput($formData['title']);
        $description = $this->sanitizeInput($formData['description']);
        $userId = $this->getUserId();

        $this->prepareAndExecuteQuery(query: "INSERT INTO workout_plan (plan_name, description, user_id) VALUES (?, ?, ?)", types: "ssi", params: [$title, $description, $userId], shouldReturn: false);
    }

    public function getAllWorkoutByUserId(): array
    {
        $userId = $this->getUserId();
        return $this->queryAndFetchAll(query: "SELECT * FROM workout_plan WHERE user_id = $userId");
    }

    public function getWorkoutPlanById(int $workoutPlanId): ?array
    {
        $stmt = $this->prepareAndExecuteQuery(query: "SELECT * FROM workout_plan where id = ?", types: "i", params: [$workoutPlanId], shouldReturn: true);

        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    public function getWorkoutDayById(int $workoutDayId): ?array
    {
        $stmt = $this->prepareAndExecuteQuery(query: "SELECT * FROM workout_day WHERE id = ?", types: "i", params: [$workoutDayId], shouldReturn: true);

        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    public function insertWorkoutDay(array $formData): void
    {
        $title = $this->sanitizeInput($formData['title']);

        $this->prepareAndExecuteQuery(query: "INSERT INTO workout_day (workout_plan_id, title) VALUES (?, ?)", types: "ss", params: [$formData['workout_plan_id'], $title], shouldReturn: false);
    }

    public function getWorkoutDayByWorkoutPlanId(int $workoutPlanId): ?array
    {
        return $this->queryAndFetchAll(query: "SELECT * FROM workout_day WHERE workout_plan_id = $workoutPlanId");
    }

    public function insertExercise(array $formData): void
    {
        $title = $this->sanitizeInput($formData['exerciseName']);
        $description = $this->sanitizeInput($formData['exerciseDescription']);

        $this->prepareAndExecuteQuery(query: "INSERT INTO exercise (title, description, workout_day_id) VALUES (?, ?, ?)", types: "sss", params: [$title, $description, $formData['workoutDayId']], shouldReturn: false);
    }

    public function getExercisesByWorkoutDayId(int $workoutDayId): array
    {
        return $this->queryAndFetchAll(query: "SELECT * FROM exercise WHERE workout_day_id = $workoutDayId");
    }

    public function removeWorkoutDay(int $workoutDayId): void
    {
        $this->dbConnection->begin_transaction();

        $this->prepareAndExecuteQuery(query: "DELETE FROM exercise WHERE workout_day_id = ?", types: "i", params: [$workoutDayId], shouldReturn: false);
        $this->prepareAndExecuteQuery(query: "DELETE FROM workout_day WHERE id = ?", types: "i", params: [$workoutDayId], shouldReturn: false);

        $this->dbConnection->commit();
    }

    public function removeWorkoutPlan(int $workoutPlanId): void
    {
        $this->dbConnection->begin_transaction();

        $this->prepareAndExecuteQuery(query: "DELETE FROM workout_day WHERE workout_plan_id = ?", types: "i", params: [$workoutPlanId], shouldReturn: false);
        $this->prepareAndExecuteQuery(query: "DELETE FROM workout_plan WHERE id = ?", types: "i", params: [$workoutPlanId], shouldReturn: false);

        $this->dbConnection->commit();
    }

    public function insertLog(array $formData): void
    {
        $sets = $this->sanitizeInput(input: $formData['sets']);
        $reps = $this->sanitizeInput(input: $formData['reps']);
        $weight = $this->sanitizeInput(input: $formData['weight']);
        $date = $formData['date'];
        $currentDate = date('Y-m-d', strtotime($date));

        $this->prepareAndExecuteQuery(
            query: "INSERT INTO workout_logs (sets, reps, weight, exercise_id, created_at) VALUES (?, ?, ?, ?, ?)",
            types: "issis",
            params: [$sets, $reps, $weight, $formData['exercise'], $currentDate],
            shouldReturn: false
        );
    }

    public function editWorkoutDayTitle(array $formData): void
    {
        $title = $this->sanitizeInput(input: $formData['workoutDayTitle']);
        $this->prepareAndExecuteQuery(query: "UPDATE workout_day SET title = ? WHERE id = ?", types: "si", params: [$title, $formData['workoutDayId']], shouldReturn: false);
    }

    public function editExercise(array $formData)
    {
        $title = $this->sanitizeInput(input: $formData['exerciseTitle']);
        $this->prepareAndExecuteQuery(query: "UPDATE exercise SET title = ? WHERE id = ?" , types: "si", params: [$title, $formData['exerciseId']], shouldReturn: false);
    }

    public function getAllLogsByExerciseId(int $exerciseId): ?array
    {
        return $this->queryAndFetchAll(query: "SELECT * FROM workout_logs WHERE exercise_id = $exerciseId");
    }

    public function removeLogById(int $logId): void
    {
        $this->prepareAndExecuteQuery(query: "DELETE FROM workout_logs WHERE id = ?", types: "i", params: [$logId], shouldReturn: false);
    }

    public function removeExercise(int $exerciseId): void
    {
        $this->dbConnection->begin_transaction();

        $this->prepareAndExecuteQuery(query: "DELETE FROM workout_logs WHERE exercise_id = ?", types: "i", params: [$exerciseId], shouldReturn: false);
        $this->prepareAndExecuteQuery(query: "DELETE FROM exercise WHERE id = ?", types: "i", params: [$exerciseId], shouldReturn: false);

        $this->dbConnection->commit();
    }

    public function getLogByExerciseId(int $exerciseId): ?array
    {
       return $this->queryAndFetchAll(query: "SELECT * FROM workout_logs WHERE exercise_id = $exerciseId");
    }
}