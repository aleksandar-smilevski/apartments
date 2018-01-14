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
}
