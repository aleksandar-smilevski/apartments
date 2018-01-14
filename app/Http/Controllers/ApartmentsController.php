<?php

namespace App\Http\Controllers;


use App\Repository\Contracts\IApartmentsRepository;
use Illuminate\Http\Request;

class ApartmentsController extends Controller
{

    protected $repository;
    /**
     * ApartmentsController constructor.
     */
    public function __construct(IApartmentsRepository $apartmentsRepository)
    {
        $this->repository = $apartmentsRepository;
    }

    public function getByLocation(Request $request){
       dd($request->query('destination'));
       dd($request->query('from'));
       dd($request->query('to'));
    }

    public function show($id){
        return $this-> repository -> getById($id);
    }


}
