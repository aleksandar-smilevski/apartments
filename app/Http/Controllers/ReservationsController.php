<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Repository\Contracts\IApartmentsRepository;
use App\Repository\Contracts\IReservationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends Controller
{
    protected $repository;
    protected $apartmentsRepository;
    /**
     * ReservationsController constructor.
     */


    public function __construct(IReservationsRepository $reservationsRepository, IApartmentsRepository $apartmentsRepository)
    {
        $this->repository = $reservationsRepository;
        $this -> apartmentsRepository = $apartmentsRepository;
    }
    public function index(){
       return  $this -> repository->getAll();
    }
    public function create(Request $request){

        $validatedData = $request->validate([
            'from' => 'required',
            'to' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        $reservation = new Reservation();
        $reservation->description = $request->input('description');
        $reservation->from = $request->input('from');
        $reservation->to = $request->input('to');

        $reservation->user_id = Auth::id();
        $reservation->apartment_id = $request->input('apartment_id');

        $reservation->price = $request->input('price');

        $result = $this->repository->create($reservation);
        if($result){
            return redirect('users/' . Auth::id())->with('success', 'Reservation has been made');
        }
        dd($result);
        return $result;
    }

    public function save($id){
        $apartment = $this -> apartmentsRepository -> getById($id);
        $reservations = $this -> repository ->getByApartmentId($id);

        return view('reservations.create')->with('apartment', $apartment)->with('reservations', $reservations);
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
