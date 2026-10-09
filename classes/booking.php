<?php

require_once __DIR__ . "/BaseModel.php";

class Booking extends BaseModel
{
    public function createBooking(
        $booking_date,
        $status,
        $member_id,
        $class_id
    ) {
        $member = $this->fetchOne(
            "SELECT member_id
             FROM members
             WHERE member_id = ?",
            "i",
            $member_id
        );

        if (!$member) {
            return false;
        }


        $class = $this->fetchOne(
            "SELECT class_id, capacity
             FROM classes
             WHERE class_id = ?",
            "i",
            $class_id
        );

        if (!$class) {
            return false;
        }


        $existingBooking = $this->fetchOne(
            "SELECT booking_id
             FROM bookings
             WHERE member_id = ?
             AND class_id = ?
             AND status != 'Cancelled'
             LIMIT 1",
            "ii",
            $member_id,
            $class_id
        );

        if ($existingBooking) {
            return false;
        }


        $bookingCount = $this->fetchOne(
            "SELECT COUNT(*) AS total
             FROM bookings
             WHERE class_id = ?
             AND status != 'Cancelled'",
            "i",
            $class_id
        );

        if ($bookingCount["total"] >= $class["capacity"]) {
            return false;
        }


        return $this->insert(
            "INSERT INTO bookings
            (
                booking_date,
                status,
                member_id,
                class_id
            )
            VALUES (?, ?, ?, ?)",
            "ssii",
            $booking_date,
            $status,
            $member_id,
            $class_id
        );
    }


    public function getBookingById($booking_id)
    {
        return $this->fetchOne(
            "SELECT
                bookings.*,
                users.full_name,
                classes.class_name,
                classes.class_date,
                classes.start_time,
                classes.capacity
             FROM bookings
             INNER JOIN members
                ON bookings.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN classes
                ON bookings.class_id = classes.class_id
             WHERE bookings.booking_id = ?",
            "i",
            $booking_id
        );
    }


    public function getBookingsByMemberId($member_id)
    {
        return $this->fetchAll(
            "SELECT
                bookings.*,
                users.full_name,
                classes.class_name,
                classes.class_date,
                classes.start_time,
                classes.capacity
             FROM bookings
             INNER JOIN members
                ON bookings.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN classes
                ON bookings.class_id = classes.class_id
             WHERE bookings.member_id = ?
             ORDER BY bookings.booking_id DESC",
            "i",
            $member_id
        );
    }


    public function getBookingsByClassId($class_id)
    {
        return $this->fetchAll(
            "SELECT
                bookings.*,
                users.full_name,
                classes.class_name,
                classes.class_date,
                classes.start_time,
                classes.capacity
             FROM bookings
             INNER JOIN members
                ON bookings.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN classes
                ON bookings.class_id = classes.class_id
             WHERE bookings.class_id = ?
             ORDER BY bookings.booking_id DESC",
            "i",
            $class_id
        );
    }

    
    public function getAllBookings()
    {
        return $this->fetchAll(
            "SELECT
                bookings.*,
                users.full_name,
                classes.class_name,
                classes.class_date,
                classes.start_time,
                classes.capacity
             FROM bookings
             INNER JOIN members
                ON bookings.member_id = members.member_id
             INNER JOIN users
                ON members.user_id = users.user_id
             INNER JOIN classes
                ON bookings.class_id = classes.class_id
             ORDER BY bookings.booking_id DESC"
        );
    }


    public function updateBooking(
        $booking_id,
        $booking_date,
        $status,
        $member_id,
        $class_id
    ) {
        $member = $this->fetchOne(
            "SELECT member_id
             FROM members
             WHERE member_id = ?",
            "i",
            $member_id
        );

        if (!$member) {
            return false;
        }


        $class = $this->fetchOne(
            "SELECT class_id, capacity
             FROM classes
             WHERE class_id = ?",
            "i",
            $class_id
        );

        if (!$class) {
            return false;
        }


        $existingBooking = $this->fetchOne(
            "SELECT booking_id
             FROM bookings
             WHERE member_id = ?
             AND class_id = ?
             AND booking_id != ?
             AND status != 'Cancelled'
             LIMIT 1",
            "iii",
            $member_id,
            $class_id,
            $booking_id
        );

        if ($existingBooking) {
            return false;
        }


        $bookingCount = $this->fetchOne(
            "SELECT COUNT(*) AS total
             FROM bookings
             WHERE class_id = ?
             AND status != 'Cancelled'
             AND booking_id != ?",
            "ii",
            $class_id,
            $booking_id
        );

        if ($bookingCount["total"] >= $class["capacity"]) {
            return false;
        }


        return $this->updateQuery(
            "UPDATE bookings
             SET
                booking_date = ?,
                status = ?,
                member_id = ?,
                class_id = ?
             WHERE booking_id = ?",
            "ssiii",
            $booking_date,
            $status,
            $member_id,
            $class_id,
            $booking_id
        );
    }


/* class get by id */


public function getById($booking_id)
{
    return $this->fetchOne(
        "SELECT
            bookings.*,
            users.full_name,
            classes.class_name
         FROM bookings
         INNER JOIN members
            ON bookings.member_id = members.member_id
         INNER JOIN users
            ON members.user_id = users.user_id
         INNER JOIN classes
            ON bookings.class_id = classes.class_id
         WHERE bookings.booking_id = ?",
        "i",
        $booking_id
    );
}


// ==========================================
// Get Bookings By Trainer
// ==========================================

public function getBookingsByTrainerId($trainer_id)
{
    return $this->fetchAll(
        "SELECT
            bookings.*,
            users.full_name,
            classes.class_name,
            classes.class_date,
            classes.start_time,
            classes.capacity
         FROM bookings
         INNER JOIN members
            ON bookings.member_id = members.member_id
         INNER JOIN users
            ON members.user_id = users.user_id
         INNER JOIN classes
            ON bookings.class_id = classes.class_id
         WHERE classes.trainer_id = ?
         ORDER BY bookings.booking_id DESC",
        "i",
        $trainer_id
    );
}


// ==========================================
// Get Booking By ID For Member
// ==========================================

public function getBookingByIdForMember(
    $booking_id,
    $member_id
) {
    return $this->fetchOne(
        "SELECT
            bookings.*,
            users.full_name,
            classes.class_name,
            classes.class_date,
            classes.start_time,
            classes.capacity
         FROM bookings
         INNER JOIN members
            ON bookings.member_id = members.member_id
         INNER JOIN users
            ON members.user_id = users.user_id
         INNER JOIN classes
            ON bookings.class_id = classes.class_id
         WHERE bookings.booking_id = ?
         AND bookings.member_id = ?",
        "ii",
        $booking_id,
        $member_id
    );
}


// ==========================================
// Get Booking By ID For Trainer
// ==========================================

public function getBookingByIdForTrainer(
    $booking_id,
    $trainer_id
) {
    return $this->fetchOne(
        "SELECT
            bookings.*,
            users.full_name,
            classes.class_name,
            classes.class_date,
            classes.start_time,
            classes.capacity
         FROM bookings
         INNER JOIN members
            ON bookings.member_id = members.member_id
         INNER JOIN users
            ON members.user_id = users.user_id
         INNER JOIN classes
            ON bookings.class_id = classes.class_id
         WHERE bookings.booking_id = ?
         AND classes.trainer_id = ?",
        "ii",
        $booking_id,
        $trainer_id
    );
}




public function getClassTrainer($class_id)
{
    return $this->fetchOne(
        "SELECT
            trainer_id
         FROM classes
         WHERE class_id = ?",
        "i",
        $class_id
    );
}


public function getBookingCountByClassId($class_id)
{
    $result = $this->fetchOne(
        "SELECT COUNT(*) AS total
         FROM bookings
         WHERE class_id = ?
         AND status != 'Cancelled'",
        "i",
        $class_id
    );

    return $result ? (int) $result["total"] : 0;
}


    public function deleteBooking($booking_id)
    {
        return $this->deleteQuery(
            "DELETE FROM bookings
             WHERE booking_id = ?",
            "i",
            $booking_id
        );
    }
}