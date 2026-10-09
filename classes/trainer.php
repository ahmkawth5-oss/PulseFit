<?php

require_once __DIR__ . "/user.php";

class Trainer extends User
{
    // =========================
    // Create Trainer
    // =========================

    public function createTrainer(
        $full_name,
        $username,
        $password,
        $phone,
        $email,
        $specialty,
        $hire_date,
        $salary,
        $birth_date,
        $image = null
    ) {
        $this->conn->begin_transaction();

        try {

            $user_id = parent::create(
                $full_name,
                $username,
                $password,
                "trainer",
                3,
                $phone,
                $email,
                "pending",
                $image
            );

            if (!$user_id) {
                throw new Exception("Failed to create user");
            }

            $trainer_id = $this->insert(
                "INSERT INTO trainers
                (
                    specialty,
                    hire_date,
                    salary,
                    user_id,
                    birth_date
                )
                VALUES (?, ?, ?, ?, ?)",
                "ssdis",
                $specialty,
                $hire_date,
                $salary,
                $user_id,
                $birth_date
            );

            if (!$trainer_id) {
                throw new Exception("Failed to create trainer");
            }

            $this->conn->commit();

            return $trainer_id;

        } catch (Exception $e) {

            $this->conn->rollback();

            return false;
        }
    }


    // =========================
    // Get Trainer By ID
    // =========================

    public function getTrainerById($trainer_id)
    {
        return $this->fetchOne(
            "SELECT
                trainers.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM trainers
             INNER JOIN users
                ON trainers.user_id = users.user_id
             WHERE trainers.trainer_id = ?",
            "i",
            $trainer_id
        );
    }


    // =========================
    // Get Trainer By User ID
    // =========================

    public function getTrainerByUserId($user_id)
    {
        return $this->fetchOne(
            "SELECT
                trainers.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM trainers
             INNER JOIN users
                ON trainers.user_id = users.user_id
             WHERE users.user_id = ?",
            "i",
            $user_id
        );
    }


    // =========================
    // Get All Trainers
    // =========================

    public function getAllTrainers()
    {
        return $this->fetchAll(
            "SELECT
                trainers.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM trainers
             INNER JOIN users
                ON trainers.user_id = users.user_id
             ORDER BY trainers.trainer_id DESC"
        );
    }


    // =========================
    // Get Active Trainers
    // =========================

    public function getActiveTrainers()
    {
        return $this->fetchAll(
            "SELECT
                trainers.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM trainers
             INNER JOIN users
                ON trainers.user_id = users.user_id
             WHERE LOWER(users.status) = 'active'
             ORDER BY trainers.trainer_id DESC"
        );
    }


    // =========================
    // Get Pending Trainers
    // =========================

    public function getPendingTrainers()
    {
        return $this->fetchAll(
            "SELECT
                trainers.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM trainers
             INNER JOIN users
                ON trainers.user_id = users.user_id
             WHERE LOWER(users.status) = 'pending'
             ORDER BY trainers.trainer_id DESC"
        );
    }


    // =========================
    // Update Trainer
    // =========================

    public function updateTrainer(
        $trainer_id,
        $full_name,
        $username,
        $phone,
        $email,
        $status,
        $specialty,
        $hire_date,
        $salary,
        $birth_date,
        $image = null
    ) {
        $trainer = $this->getTrainerById($trainer_id);

        if (!$trainer) {
            return false;
        }

        $this->conn->begin_transaction();

        try {

            $user_updated = $this->updateQuery(
                "UPDATE users
                 SET
                    full_name = ?,
                    username = ?,
                    phone = ?,
                    email = ?,
                    status = ?
                 WHERE user_id = ?",
                "sssssi",
                $full_name,
                $username,
                $phone,
                $email,
                $status,
                $trainer["user_id"]
            );

            if ($user_updated === false) {
                throw new Exception("Failed to update user");
            }


            if ($image !== null) {

                $image_updated = $this->updateQuery(
                    "UPDATE users
                     SET image = ?
                     WHERE user_id = ?",
                    "si",
                    $image,
                    $trainer["user_id"]
                );

                if ($image_updated === false) {
                    throw new Exception("Failed to update image");
                }
            }


            $trainer_updated = $this->updateQuery(
                "UPDATE trainers
                 SET
                    specialty = ?,
                    hire_date = ?,
                    salary = ?,
                    birth_date = ?
                 WHERE trainer_id = ?",
                "ssdsi",
                $specialty,
                $hire_date,
                $salary,
                $birth_date,
                $trainer_id
            );

            if ($trainer_updated === false) {
                throw new Exception("Failed to update trainer");
            }


            $this->conn->commit();

            return true;

        } catch (Exception $e) {

            $this->conn->rollback();

            return false;
        }
    }


    // =========================
    // Approve Trainer
    // =========================

    public function approveTrainer($trainer_id)
    {
        $trainer = $this->getTrainerById($trainer_id);

        if (!$trainer) {
            return false;
        }

        return $this->updateQuery(
            "UPDATE users
             SET status = 'Active'
             WHERE user_id = ?",
            "i",
            $trainer["user_id"]
        );
    }


    // =========================
    // Delete Trainer
    // =========================

    public function deleteTrainer($trainer_id)
    {
        $trainer = $this->getTrainerById($trainer_id);

        if (!$trainer) {
            return false;
        }

        $this->conn->begin_transaction();

        try {

            $trainer_deleted = $this->deleteQuery(
                "DELETE FROM trainers
                 WHERE trainer_id = ?",
                "i",
                $trainer_id
            );

            if ($trainer_deleted === false) {
                throw new Exception("Failed to delete trainer");
            }


            $user_deleted = $this->deleteQuery(
                "DELETE FROM users
                 WHERE user_id = ?",
                "i",
                $trainer["user_id"]
            );

            if ($user_deleted === false) {
                throw new Exception("Failed to delete user");
            }


            $this->conn->commit();

            return true;

        } catch (Exception $e) {

            $this->conn->rollback();

            return false;
        }
    }
}