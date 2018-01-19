<?php

namespace App\Http\Controllers;

use App\Repository\Contracts\IReservationsRepository;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    protected $repository;
    /**
     * ReservationsController constructor.
     */
    public function __construct(IReservationsRepository $reservationsRepository)
    {
        $this->repository = $reservationsRepository;
    }
    public function index(){
       return  $this -> repository->getAll();
    }

    public function show($id){
        return  $this -> repository->getById($id);
    }

    public function listAllForApartment($apartmentId){
        return $this -> repository-> getByApartmentId($apartmentId);
    }

    public function showForApartment( $apartmentId, $reservationId){

        return $this -> repository->getByApartmentIdAndReservationId($apartmentId, $reservationId);
    }
}
