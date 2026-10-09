<?php

require_once __DIR__ . "/BaseModel.php";

class Payment extends BaseModel
{
    public function createPayment(
        $payment_date,
        $amount,
        $payment_method,
        $payment_status,
        $subscription_id
    ) {
        return $this->insert(
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

    }

    public function getPaymentById($payment_id)
    {
        return $this->fetchOne(
            "SELECT
                payments.*,
                subscriptions.member_id,
                subscriptions.membership_id,
                users.full_name,
                memberships.membership_name
             FROM payments
             INNER JOIN subscriptions
                ON payments.subscription_id = subscriptions.subscription_id
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             WHERE payments.payment_id = ?",
            "i",
            $payment_id
        );
    }


    public function getPaymentsBySubscriptionId($subscription_id)
    {
        return $this->fetchAll(
            "SELECT
                payments.*,
                subscriptions.member_id,
                subscriptions.membership_id,
                users.full_name,
                memberships.membership_name
             FROM payments
             INNER JOIN subscriptions
                ON payments.subscription_id = subscriptions.subscription_id
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             WHERE payments.subscription_id = ?
             ORDER BY payments.payment_id DESC",
            "i",
            $subscription_id
        );
    }


    public function getAllPayments()
    {
        return $this->fetchAll(
            "SELECT
                payments.*,
                subscriptions.member_id,
                subscriptions.membership_id,
                users.full_name,
                memberships.membership_name
             FROM payments
             INNER JOIN subscriptions
                ON payments.subscription_id = subscriptions.subscription_id
             INNER JOIN members
                ON subscriptions.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN memberships
                ON subscriptions.membership_id = memberships.membership_id
             ORDER BY payments.payment_id DESC"
        );
    }


    public function updatePayment(
        $payment_id,
        $payment_date,
        $amount,
        $payment_method,
        $payment_status,
        $subscription_id
    ) {
        return $this->updateQuery(
            "UPDATE payments
             SET
                payment_date = ?,
                amount = ?,
                payment_method = ?,
                payment_status = ?,
                subscription_id = ?
             WHERE payment_id = ?",
            "sdssii",
            $payment_date,
            $amount,
            $payment_method,
            $payment_status,
            $subscription_id,
            $payment_id
        );
    }


    public function deletePayment($payment_id)
    {
        return $this->deleteQuery(
            "DELETE FROM payments
             WHERE payment_id = ?",
            "i",
            $payment_id
        );
    }
}