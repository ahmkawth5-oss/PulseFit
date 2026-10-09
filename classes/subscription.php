<?php

require_once __DIR__ . "/BaseModel.php";

class Subscription extends BaseModel
{
    // ==========================================
    // Create Subscription
    // ==========================================

    public function createSubscription(
        $member_id,
        $membership_id,
        $start_date,
        $end_date,
        $status
    ) {
        return $this->insert(
            "INSERT INTO subscriptions
            (
                member_id,
                membership_id,
                start_date,
                end_date,
                status
            )
            VALUES (?, ?, ?, ?, ?)",
            "iisss",
            $member_id,
            $membership_id,
            $start_date,
            $end_date,
            $status
        );
    }


    // ==========================================
    // Get Subscription By ID
    // ==========================================

    public function getSubscriptionById($subscription_id)
    {
        return $this->fetchOne(
            "SELECT
                subscriptions.*,
                members.member_id,
                members.user_id,
                users.full_name,
                memberships.membership_name,
                memberships.duration,
                memberships.price
             FROM subscriptions
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             WHERE subscriptions.subscription_id = ?",
            "i",
            $subscription_id
        );
    }


    // ==========================================
    // Get Subscriptions By Member ID
    // ==========================================

    public function getSubscriptionsByMemberId($member_id)
    {
        return $this->fetchAll(
            "SELECT
                subscriptions.*,
                members.member_id,
                members.user_id,
                users.full_name,
                memberships.membership_name,
                memberships.duration,
                memberships.price
             FROM subscriptions
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             WHERE subscriptions.member_id = ?
             ORDER BY subscriptions.subscription_id DESC",
            "i",
            $member_id
        );
    }


    // ==========================================
    // Get Subscriptions By User ID
    // ==========================================

    public function getSubscriptionsByUserId($user_id)
    {
        return $this->fetchAll(
            "SELECT
                subscriptions.*,
                members.member_id,
                members.user_id,
                users.full_name,
                memberships.membership_name,
                memberships.duration,
                memberships.price
             FROM subscriptions
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             WHERE members.user_id = ?
             ORDER BY subscriptions.subscription_id DESC",
            "i",
            $user_id
        );
    }


    // ==========================================
    // Get All Subscriptions
    // ==========================================

    public function getAllSubscriptions()
    {
        return $this->fetchAll(
            "SELECT
                subscriptions.*,
                members.member_id,
                members.user_id,
                users.full_name,
                memberships.membership_name,
                memberships.duration,
                memberships.price
             FROM subscriptions
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             ORDER BY subscriptions.subscription_id DESC"
        );
    }


    // ==========================================
    // Update Subscription
    // ==========================================

    public function updateSubscription(
        $subscription_id,
        $member_id,
        $membership_id,
        $start_date,
        $end_date,
        $status
    ) {
        return $this->updateQuery(
            "UPDATE subscriptions
             SET
                member_id = ?,
                membership_id = ?,
                start_date = ?,
                end_date = ?,
                status = ?
             WHERE subscription_id = ?",
            "iisssi",
            $member_id,
            $membership_id,
            $start_date,
            $end_date,
            $status,
            $subscription_id
        );
    }


    // ==========================================
// Create Subscription With Payment
// ==========================================

public function createSubscriptionWithPayment(
    $member_id,
    $membership_id,
    $start_date,
    $end_date,
    $status,
    $payment_date,
    $amount,
    $payment_method,
    $payment_status
) {
    $this->conn->begin_transaction();

    try {

        $subscription_id = $this->insert(
            "INSERT INTO subscriptions
            (
                member_id,
                membership_id,
                start_date,
                end_date,
                status
            )
            VALUES (?, ?, ?, ?, ?)",
            "iisss",
            $member_id,
            $membership_id,
            $start_date,
            $end_date,
            $status
        );

        if (!$subscription_id) {
            throw new Exception("Failed to create subscription");
        }


        $payment_id = $this->insert(
            "INSERT INTO payments
            (
                payment_date,
                amount,
                payment_method,
                payment_status,
                subscription_id
            )
            VALUES (?, ?, ?, ?, ?)",
            "sdssi",
            $payment_date,
            $amount,
            $payment_method,
            $payment_status,
            $subscription_id
        );

        if (!$payment_id) {
            throw new Exception("Failed to create payment");
        }


        $this->conn->commit();

        return [
            "subscription_id" => $subscription_id,
            "payment_id" => $payment_id
        ];

    } catch (Exception $e) {

        $this->conn->rollback();

        return false;
    }
}


    // ==========================================
    // Delete Subscription
    // ==========================================

    public function deleteSubscription($subscription_id)
    {
        return $this->deleteQuery(
            "DELETE FROM subscriptions
             WHERE subscription_id = ?",
            "i",
            $subscription_id
        );
    }
}