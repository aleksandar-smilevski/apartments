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
use Illuminate\Support\Facades\DB;

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
        return Reservation::where("apartment_id", $apartment_id)->get();
    }

    public function getByApartmentIdAndReservationId(int $apartment_id,int  $reservation_id) {
        return Reservation::where("apartment_id", $apartment_id) -> where("id", $reservation_id) -> first();
    }

    public function getByUserId(int $user_id) {
        return Reservation::where("user_id" ,$user_id)->get();
    }

    public function getByUserIdAndReservationId(int $user_id,int  $reservation_id) {
        return Reservation::where("user_id" , $user_id) -> where("id", $reservation_id) -> first();
    }

    public function getAvailableApartmentsForPeriod($id, $from, $to) {
        return  Reservation::where('apartment_id',$id)->where("from","<=", $from)->select('apartment_id')->distinct()->get()->toArray();
    }

    public function getUpcomingReservations($user_id)
    {
        //$reservations = Reservation::where('user_id', $user_id)->where('from', '>=', date('Y-m-d'))->get();
        $reservations = DB::table('reservations')
                ->join('apartments', 'apartments.id', '=', 'reservations.apartment_id')
                ->where('reservations.user_id', $user_id)
                ->where('reservations.from', '>=', date('Y-m-d'))
                ->select('reservations.*', 'apartments.name as apartment_name')->get();
        return $reservations;
    }
}