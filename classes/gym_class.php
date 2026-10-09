<?php

require_once __DIR__ . "/BaseModel.php";

class ClassModel extends BaseModel
{
    // =========================
    // Create Class
    // =========================

    public function createClass(
        $class_name,
        $class_date,
        $start_time,
        $capacity,
        $trainer_id
    ) {
        return $this->insert(
            "INSERT INTO classes
            (
                class_name,
                class_date,
                start_time,
                capacity,
                trainer_id
            )
            VALUES (?, ?, ?, ?, ?)",
            "sssii",
            $class_name,
            $class_date,
            $start_time,
            $capacity,
            $trainer_id
        );
    }


    // =========================
    // Get Class By ID
    // =========================

    public function getClassById($class_id)
    {
        return $this->fetchOne(
            "SELECT
                classes.*,
                trainers.specialty,
                users.full_name
             FROM classes
             INNER JOIN trainers
                ON classes.trainer_id = trainers.trainer_id
             INNER JOIN users
                ON trainers.user_id = users.user_id
             WHERE classes.class_id = ?",
            "i",
            $class_id
        );
    }


    // =========================
    // Get Classes By Trainer ID
    // =========================

    public function getClassesByTrainerId($trainer_id)
    {
        return $this->fetchAll(
            "SELECT
                classes.*,
                trainers.specialty,
                users.full_name
             FROM classes
             INNER JOIN trainers
                ON classes.trainer_id = trainers.trainer_id
             INNER JOIN users
                ON trainers.user_id = users.user_id
             WHERE classes.trainer_id = ?
             ORDER BY classes.class_id DESC",
            "i",
            $trainer_id
        );
    }


    // =========================
    // Get All Classes
    // =========================

    public function getAllClasses()
    {
        return $this->fetchAll(
            "SELECT
                classes.*,
                trainers.specialty,
                users.full_name
             FROM classes
             INNER JOIN trainers
                ON classes.trainer_id = trainers.trainer_id
             INNER JOIN users
                ON trainers.user_id = users.user_id
             ORDER BY classes.class_id DESC"
        );
    }


    public function getUpcomingClasses()
{
    return $this->fetchAll(
        "SELECT
            classes.*,
            trainers.specialty,
            users.full_name
         FROM classes
         INNER JOIN trainers
            ON classes.trainer_id = trainers.trainer_id
         INNER JOIN users
            ON trainers.user_id = users.user_id
         WHERE classes.class_date >= CURDATE()
         AND LOWER(users.status) = ?
         ORDER BY classes.class_date ASC, classes.start_time ASC"
        ,
        "s",
        "active"
    );
}


    // =========================
    // Update Class
    // =========================

    public function updateClass(
        $class_id,
        $class_name,
        $class_date,
        $start_time,
        $capacity,
        $trainer_id
    ) {
        return $this->updateQuery(
            "UPDATE classes
             SET
                class_name = ?,
                class_date = ?,
                start_time = ?,
                capacity = ?,
                trainer_id = ?
             WHERE class_id = ?",
            "sssiii",
            $class_name,
            $class_date,
            $start_time,
            $capacity,
            $trainer_id,
            $class_id
        );
    }


    // =========================
    // Delete Class
    // =========================

    public function deleteClass($class_id)
    {
        return $this->deleteQuery(
            "DELETE FROM classes
             WHERE class_id = ?",
            "i",
            $class_id
        );
    }
}