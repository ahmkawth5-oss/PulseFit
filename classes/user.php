<?php

require_once __DIR__ . "/BaseModel.php";

class User extends BaseModel
{
    // =========================
    // Create User
    // =========================

    public function create(
        $full_name,
        $username,
        $password,
        $role,
        $profile_id,
        $phone,
        $email,
        $status,
        $image = null
    ) {
        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        return $this->insert(
            "INSERT INTO users
            (
                full_name,
                username,
                password,
                role,
                profile_id,
                phone,
                email,
                status,
                image
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            "ssssissss",
            $full_name,
            $username,
            $hashed_password,
            $role,
            $profile_id,
            $phone,
            $email,
            $status,
            $image
        );
    }


    // =========================
    // Get User By ID
    // =========================

    public function getById($user_id)
    {
        return $this->fetchOne(
            "SELECT
                users.*,
                profiles.profile_name
             FROM users
             LEFT JOIN profiles
                ON users.profile_id = profiles.profile_id
             WHERE users.user_id = ?",
            "i",
            $user_id
        );
    }


    // =========================
    // Get User By Username
    // =========================

    public function getByUsername($username)
    {
        return $this->fetchOne(
            "SELECT
                users.*,
                profiles.profile_name
             FROM users
             LEFT JOIN profiles
                ON users.profile_id = profiles.profile_id
             WHERE users.username = ?",
            "s",
            $username
        );
    }


    // =========================
    // Get User By Email
    // =========================

    public function getByEmail($email)
    {
        return $this->fetchOne(
            "SELECT
                users.*,
                profiles.profile_name
             FROM users
             LEFT JOIN profiles
                ON users.profile_id = profiles.profile_id
             WHERE users.email = ?",
            "s",
            $email
        );
    }


    // =========================
    // Get All Users
    // =========================

    public function getAll()
    {
        return $this->fetchAll(
            "SELECT
                users.*,
                profiles.profile_name
             FROM users
             LEFT JOIN profiles
                ON users.profile_id = profiles.profile_id
             ORDER BY users.user_id DESC"
        );
    }


    // =========================
    // Get Managers
    // =========================

    public function getManagers()
    {
        return $this->fetchAll(
            "SELECT
                users.*,
                profiles.profile_name
             FROM users
             LEFT JOIN profiles
                ON users.profile_id = profiles.profile_id
             WHERE users.profile_id = ?
             ORDER BY users.user_id DESC",
            "i",
            2
        );
    }


    // =========================
    // Get Active Managers
    // =========================

    public function getActiveManagers()
    {
        return $this->fetchAll(
            "SELECT
                users.*,
                profiles.profile_name
             FROM users
             LEFT JOIN profiles
                ON users.profile_id = profiles.profile_id
             WHERE users.profile_id = ?
             AND users.status = ?
             ORDER BY users.user_id DESC",
            "is",
            2,
            "active"
        );
    }

// =========================
// Get Admins
// =========================

public function getAdmins()
{
    return $this->fetchAll(
        "SELECT
            users.*,
            profiles.profile_name
         FROM users
         LEFT JOIN profiles
            ON users.profile_id = profiles.profile_id
         WHERE users.profile_id = ?
         ORDER BY users.user_id DESC",
        "i",
        1
    );
}


    // =========================
    // Update User
    // =========================

    public function update(
        $user_id,
        $full_name,
        $username,
        $role,
        $profile_id,
        $phone,
        $email,
        $status
    ) {
        return $this->updateQuery(
            "UPDATE users
             SET
                full_name = ?,
                username = ?,
                role = ?,
                profile_id = ?,
                phone = ?,
                email = ?,
                status = ?
             WHERE user_id = ?",
            "sssisssi",
            $full_name,
            $username,
            $role,
            $profile_id,
            $phone,
            $email,
            $status,
            $user_id
        );
    }


    // =========================
    // Update User Image
    // =========================

    public function updateImage(
        $user_id,
        $image
    ) {
        return $this->updateQuery(
            "UPDATE users
             SET image = ?
             WHERE user_id = ?",
            "si",
            $image,
            $user_id
        );
    }


    // =========================
    // Update Password
    // =========================

    public function updatePassword(
        $user_id,
        $password
    ) {
        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        return $this->updateQuery(
            "UPDATE users
             SET password = ?
             WHERE user_id = ?",
            "si",
            $hashed_password,
            $user_id
        );
    }


    // =========================
    // Delete User
    // =========================

    public function delete($user_id)
    {
        return $this->deleteQuery(
            "DELETE FROM users
             WHERE user_id = ?",
            "i",
            $user_id
        );
    }
}