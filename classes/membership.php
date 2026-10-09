<?php

require_once __DIR__ . "/BaseModel.php";

class Membership extends BaseModel
{
    public function createMembership(
        $membership_name,
        $duration,
        $price,
        $description
    ) {
        return $this->insert(
            "INSERT INTO memberships
            (
                membership_name,
                duration,
                price,
                description
            )
            VALUES (?, ?, ?, ?)",
            "sids",
            $membership_name,
            $duration,
            $price,
            $description
        );
    }


    public function getMembershipById($membership_id)
    {
        return $this->fetchOne(
            "SELECT *
             FROM memberships
             WHERE membership_id = ?",
            "i",
            $membership_id
        );
    }


    public function getAllMemberships()
    {
        return $this->fetchAll(
            "SELECT *
             FROM memberships
             ORDER BY membership_id DESC"
        );
    }


    public function updateMembership(
        $membership_id,
        $membership_name,
        $duration,
        $price,
        $description
    ) {
        return $this->updateQuery(
            "UPDATE memberships
             SET
                membership_name = ?,
                duration = ?,
                price = ?,
                description = ?
             WHERE membership_id = ?",
            "sidsi",
            $membership_name,
            $duration,
            $price,
            $description,
            $membership_id
        );
    }


    public function deleteMembership($membership_id)
    {
        return $this->deleteQuery(
            "DELETE FROM memberships
             WHERE membership_id = ?",
            "i",
            $membership_id
        );
    }
}