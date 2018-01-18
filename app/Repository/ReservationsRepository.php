<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 14.1.2018
 * Time: 22:11
 */

namespace App\Repository;


use App\Models\Reservation;
use App\Repository\Contracts\IReservationsRepository;

class ReservationsRepository implements IReservationsRepository
{

    public function getAll()
    {
        return Reservation::all();
    }

    public function getById(int $id)
    {
        return Reservation::where("id", $id)->first();
    }

    public function getByApartmentId(int $apartment_id) {
        return Reservation::where("apartment_id", $apartment_id)->first();
    }

    public function getByUserId(int $user_id) {
        return Reservation::where("user_id" ,$user_id)->first();
    }

}