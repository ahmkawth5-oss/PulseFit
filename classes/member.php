<?php

require_once __DIR__ . "/user.php";

class Member extends User
{
    // =========================
    // Create Member
    // =========================

    public function createMember(
        $full_name,
        $username,
        $password,
        $phone,
        $email,
        $status,
        $gender,
        $birth_date,
        $join_date,
        $image = null
    ) {
        $this->conn->begin_transaction();

        try {

            $user_id = parent::create(
                $full_name,
                $username,
                $password,
                "member",
                4,
                $phone,
                $email,
                $status,
                $image
            );

            if (!$user_id) {
                throw new Exception("Failed to create user");
            }

            $member_id = $this->insert(
                "INSERT INTO members
                (
                    gender,
                    birth_date,
                    join_date,
                    user_id
                )
                VALUES (?, ?, ?, ?)",
                "sssi",
                $gender,
                $birth_date,
                $join_date,
                $user_id
            );

            if (!$member_id) {
                throw new Exception("Failed to create member");
            }

            $this->conn->commit();

            return $member_id;

        } catch (Exception $e) {

            $this->conn->rollback();

            return false;
        }
    }


    // =========================
    // Get Member By ID
    // =========================

    public function getById($member_id)
    {
        return $this->fetchOne(
            "SELECT
                members.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM members
             INNER JOIN users
                ON members.user_id = users.user_id
             WHERE members.member_id = ?",
            "i",
            $member_id
        );
    }


    // =========================
    // Get Member By User ID
    // =========================

    public function getByUserId($user_id)
    {
        return $this->fetchOne(
            "SELECT
                members.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM members
             INNER JOIN users
                ON members.user_id = users.user_id
             WHERE users.user_id = ?",
            "i",
            $user_id
        );
    }


    // =========================
    // Get All Members
    // =========================

    public function getAll()
    {
        return $this->fetchAll(
            "SELECT
                members.*,
                users.full_name,
                users.username,
                users.phone,
                users.email,
                users.status,
                users.image
             FROM members
             INNER JOIN users
                ON members.user_id = users.user_id
             ORDER BY members.member_id DESC"
        );
    }


    // =========================
    // Update Member
    // =========================

    public function updateMember(
        $member_id,
        $full_name,
        $username,
        $phone,
        $email,
        $status,
        $gender,
        $birth_date,
        $join_date,
        $image = null
    ) {
        $member = $this->getById($member_id);

        if (!$member) {
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
                $member["user_id"]
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
                    $member["user_id"]
                );

                if ($image_updated === false) {
                    throw new Exception("Failed to update image");
                }
            }


            $member_updated = $this->updateQuery(
                "UPDATE members
                 SET
                    gender = ?,
                    birth_date = ?,
                    join_date = ?
                 WHERE member_id = ?",
                "sssi",
                $gender,
                $birth_date,
                $join_date,
                $member_id
            );

            if ($member_updated === false) {
                throw new Exception("Failed to update member");
            }


            $this->conn->commit();

            return true;

        } catch (Exception $e) {

            $this->conn->rollback();

            return false;
        }
    }


    // =========================
    // Delete Member
    // =========================

    public function deleteMember($member_id)
    {
        $member = $this->getById($member_id);

        if (!$member) {
            return false;
        }

        $this->conn->begin_transaction();

        try {

            $member_deleted = $this->deleteQuery(
                "DELETE FROM members
                 WHERE member_id = ?",
                "i",
                $member_id
            );

            if ($member_deleted === false) {
                throw new Exception("Failed to delete member");
            }


            $user_deleted = $this->deleteQuery(
                "DELETE FROM users
                 WHERE user_id = ?",
                "i",
                $member["user_id"]
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