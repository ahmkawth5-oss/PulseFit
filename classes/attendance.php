<?php

require_once __DIR__ . "/BaseModel.php";

class Attendance extends BaseModel
{
    /*
    |--------------------------------------------------------------------------
    | Create Attendance
    |--------------------------------------------------------------------------
    */

    public function createAttendance(
        $check_in,
        $check_out,
        $user_id,
        $class_id = null
    ) {
        // Check that the user exists
        $user = $this->fetchOne(
            "SELECT user_id
             FROM users
             WHERE user_id = ?",
            "i",
            $user_id
        );

        if (!$user) {
            return false;
        }


        // Check that the class exists if a class was selected
        if ($class_id !== null) {

            $class = $this->fetchOne(
                "SELECT class_id
                 FROM classes
                 WHERE class_id = ?",
                "i",
                $class_id
            );

            if (!$class) {
                return false;
            }
        }


        // Prevent another open attendance record for the same user
        $existingAttendance = $this->fetchOne(
            "SELECT attendance_id
             FROM attendance
             WHERE user_id = ?
             AND check_out IS NULL
             LIMIT 1",
            "i",
            $user_id
        );

        if ($existingAttendance) {
            return false;
        }


        return $this->insert(
            "INSERT INTO attendance
            (
                check_in,
                check_out,
                user_id,
                class_id
            )
            VALUES (?, ?, ?, ?)",
            "ssii",
            $check_in,
            $check_out,
            $user_id,
            $class_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get Attendance By ID
    |--------------------------------------------------------------------------
    */

    public function getById($attendance_id)
    {
        return $this->fetchOne(
            "SELECT
                attendance.*,
                users.full_name,
                users.username,
                users.role,
                classes.class_name,
                classes.class_date,
                classes.start_time
             FROM attendance
             INNER JOIN users
                ON attendance.user_id = users.user_id
             LEFT JOIN classes
                ON attendance.class_id = classes.class_id
             WHERE attendance.attendance_id = ?",
            "i",
            $attendance_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get Attendance By ID For Owner
    |--------------------------------------------------------------------------
    */

    public function getByIdForUser(
        $attendance_id,
        $user_id
    ) {
        return $this->fetchOne(
            "SELECT
                attendance.*,
                users.full_name,
                users.username,
                users.role,
                classes.class_name,
                classes.class_date,
                classes.start_time
             FROM attendance
             INNER JOIN users
                ON attendance.user_id = users.user_id
             LEFT JOIN classes
                ON attendance.class_id = classes.class_id
             WHERE attendance.attendance_id = ?
             AND attendance.user_id = ?",
            "ii",
            $attendance_id,
            $user_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get Attendance By User ID
    |--------------------------------------------------------------------------
    */

    public function getAttendanceByUserId($user_id)
    {
        return $this->fetchAll(
            "SELECT
                attendance.*,
                users.full_name,
                users.username,
                users.role,
                classes.class_name,
                classes.class_date,
                classes.start_time
             FROM attendance
             INNER JOIN users
                ON attendance.user_id = users.user_id
             LEFT JOIN classes
                ON attendance.class_id = classes.class_id
             WHERE attendance.user_id = ?
             ORDER BY attendance.attendance_id DESC",
            "i",
            $user_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get Attendance By Class ID
    |--------------------------------------------------------------------------
    */

    public function getAttendanceByClassId($class_id)
    {
        return $this->fetchAll(
            "SELECT
                attendance.*,
                users.full_name,
                users.username,
                users.role,
                classes.class_name,
                classes.class_date,
                classes.start_time
             FROM attendance
             INNER JOIN users
                ON attendance.user_id = users.user_id
             LEFT JOIN classes
                ON attendance.class_id = classes.class_id
             WHERE attendance.class_id = ?
             ORDER BY attendance.attendance_id DESC",
            "i",
            $class_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get All Attendance
    |--------------------------------------------------------------------------
    */

    public function getAllAttendance()
    {
        return $this->fetchAll(
            "SELECT
                attendance.*,
                users.full_name,
                users.username,
                users.role,
                classes.class_name,
                classes.class_date,
                classes.start_time
             FROM attendance
             INNER JOIN users
                ON attendance.user_id = users.user_id
             LEFT JOIN classes
                ON attendance.class_id = classes.class_id
             ORDER BY attendance.attendance_id DESC"
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Attendance
    |--------------------------------------------------------------------------
    */

    public function updateAttendance(
        $attendance_id,
        $check_in,
        $check_out,
        $user_id,
        $class_id = null
    ) {
        // Check that the user exists
        $user = $this->fetchOne(
            "SELECT user_id
             FROM users
             WHERE user_id = ?",
            "i",
            $user_id
        );

        if (!$user) {
            return false;
        }


        // Check that the class exists if a class was selected
        if ($class_id !== null) {

            $class = $this->fetchOne(
                "SELECT class_id
                 FROM classes
                 WHERE class_id = ?",
                "i",
                $class_id
            );

            if (!$class) {
                return false;
            }
        }


        // Prevent another open attendance record for the same user
        $existingAttendance = $this->fetchOne(
            "SELECT attendance_id
             FROM attendance
             WHERE user_id = ?
             AND attendance_id != ?
             AND check_out IS NULL
             LIMIT 1",
            "ii",
            $user_id,
            $attendance_id
        );

        if ($existingAttendance) {
            return false;
        }


        return $this->updateQuery(
            "UPDATE attendance
             SET
                check_in = ?,
                check_out = ?,
                user_id = ?,
                class_id = ?
             WHERE attendance_id = ?",
            "ssiii",
            $check_in,
            $check_out,
            $user_id,
            $class_id,
            $attendance_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Attendance
    |--------------------------------------------------------------------------
    */

    public function deleteAttendance($attendance_id)
    {
        return $this->deleteQuery(
            "DELETE FROM attendance
             WHERE attendance_id = ?",
            "i",
            $attendance_id
        );
    }
}