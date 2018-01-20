<?php

namespace App\Http\Controllers;


use App\Models\Apartment;
use App\Repository\Contracts\IApartmentsRepository;

use App\Repository\Contracts\IReservationsRepository;
use App\Repository\Contracts\IReviewsRepository;
use App\Repository\Contracts\IUsersRepository;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentsController extends Controller
{

    protected $repository;
    protected $reservationsRepository;
    protected $userRepository;
    protected $reviewsRepository;

    /**
     * ApartmentsController constructor.
     */
    public function __construct(IApartmentsRepository $apartmentsRepository, IReservationsRepository $reservationsRepository,IReviewsRepository $reviewsRepository, IUsersRepository $usersRepository)
    {
        $this->repository = $apartmentsRepository;
        $this->userRepository = $usersRepository;
        $this->reservationsRepository = $reservationsRepository;
        $this->reviewsRepository = $reviewsRepository;

    }

    public function getByLocation(Request $request){
        $allApartments = $this -> repository->getAll();
        $apartments = [];
        $availableApartmentsIds = [];
        $users = [];
        foreach($allApartments as $apartment){
            $reservations= $this -> reservationsRepository -> getAvailableApartmentsForPeriod($apartment->id, $request->from , $request->to);
            if(count($reservations) == 0){
                array_push($availableApartmentsIds, $apartment->id);
                array_push($users, $apartment->user_id);
            }
        }
        $apartmentObjects = $this->repository -> getAvailableApartmentsFromIdsArray($availableApartmentsIds);
        foreach($apartmentObjects as $apartment){
            $apartment["username"] = $this->userRepository->getById($apartment->user_id)->name;
        }

        return view('apartments.list')->with('apartments', $apartmentObjects);
    }

    public function geocode(Request $request){
        if($request->input('address') == null){
            return response()->json([], 500);
        }
        $location = Geocoder::geocode($request->input('address'))->get();
        if($location == null){
            return response()->json([], 404);
        }
        return $location->first()->toArray();
    }

    public function show($id){
        $apartment = $this->repository ->getById($id);
        $user = $this -> userRepository -> getById($apartment -> user_id);
        $reviews = $this -> reviewsRepository -> getByApartmentId($apartment -> id);

        foreach ($reviews as $review){
            $helperUser = $this->userRepository->getById($review -> user_id);
            $review['username'] = $helperUser-> name;
        }

        return view('apartments.show')->with('apartment', $apartment)->with('user',$user)->with('reviews',$reviews);
    }

    public function save(){
        return view('apartments.create');
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'addressLat' => 'required',
            'addressLng' => 'required',
            'price' => 'required|numeric'
        ]);
        $apartment = new Apartment();
        $apartment->name = $request->input('name');
        $apartment->description = $request->input('description');
        $apartment->longitude = $request->input('addressLng');
        $apartment->latitude = $request->input('addressLat');
        $apartment->address = $request->input('address');
        $apartment->price = $request->input('price');
        $apartment->user_id = Auth::id();

        $result = $this->repository->create($apartment);
        if($result){
            return back()->with('success', 'Apartment has been added');
        }
        return $result;
    }

    public function edit(int $id){
        $apartment = $this->repository->getById($id);
        if($apartment == null){
            return response()->json([], 404);
        }
        return view('apartments.edit', compact('apartment', 'id'));
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'addressLat' => 'required',
            'addressLng' => 'required',
            'price' => 'required|numeric'
        ]);
        $apartment = new Apartment();
        $apartment->name = $request->get('name');
        $apartment->description = $request->get('description');
        $apartment->address= $request->input('address');
        $apartment->longitude = $request->input('addressLng');
        $apartment->latitude = $request->input('addressLat');
        $apartment->price = $request->input('price');
        $apartment->user_id = Auth::id();
        $result = $this->repository->update($apartment, $id);
        if($result){
            return back()->with('success', 'Apartment has been updated');
        }
        return $result;
    }

}
