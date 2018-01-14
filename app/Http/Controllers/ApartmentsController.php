<?php

namespace App\Http\Controllers;


use App\Models\Apartment;
use App\Repository\Contracts\IApartmentsRepository;

use Geocoder\Laravel\Facades\Geocoder;
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

    public function save(){
        return view('apartments.create');
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required'
        ]);
        $apartment = new Apartment();
        $apartment->name = $request->input('name');
        $apartment->description = $request->input('description');
        $location = Geocoder::geocode($request->input('address'))->get()->first()->getCoordinates();
        $apartment->longitude = $location->getLongitude();
        $apartment->latitude = $location->getLatitude();

        $result = $this->repository->create($apartment);
        if($result){
            return back()->with('success', 'Apartment has been added');
        }
        return $result;
    }

    public function edit(int $id){
        $apartment = $this->repository->getById($id);
        if($apartment == null){
            return response()->json(["error" => "404! Not Found"]);
        }
        $address = Geocoder::reverse($apartment->latitude, $apartment->longitude)->get()->first()->getFormattedAddress();
        return view('apartments.edit', compact('apartment', 'id', 'address'));
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required'
        ]);
        $apartment = new Apartment();
        $apartment->name = $request->get('name');
        $apartment->description = $request->get('description');
        $location = Geocoder::geocode($request->input('address'))->get()->first()->getCoordinates();
        $apartment->longitude = $location->getLongitude();
        $apartment->latitude = $location->getLatitude();
        $result = $this->repository->update($apartment, $id);
        if($result){
            return back()->with('success', 'Apartment has been updated');
        }
        return $result;
    }

}
