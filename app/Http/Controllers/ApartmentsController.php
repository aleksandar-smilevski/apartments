<?php

namespace App\Http\Controllers;


use App\Models\Apartment;
    use App\Models\Reservation;
use App\Repository\Contracts\IApartmentsRepository;

use App\Repository\Contracts\IReservationsRepository;
use App\Repository\Contracts\IReviewsRepository;
use App\Repository\Contracts\IUsersRepository;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $destination = $request->query('destination');
        if($destination == null) {
            abort(500);
        }
        $location = Geocoder::geocode($destination)->get();
        if(count($location) == 0){
            abort(500);
        }
        $location = $location->first()->toArray();
        if($request->from != null and $request->to != null){
            $time = strtotime($request->from);
            $from = date('Y-m-d',$time);
            $time = strtotime($request->to);
            $to = date('Y-m-d',$time);

            $availableApartments = $this->repository->getAvailableApartments($from, $to, $location["latitude"], $location["longitude"]);

            $apartmentObjects = [];
            foreach($availableApartments as $apartment){
                $apartment['username'] = $this->userRepository->getById($apartment["user_id"])->name;
                array_push($apartmentObjects, $apartment);
            }
            $data = array(
                'apartments' => $apartmentObjects,
                'location' => $location,
                'dates' => array('from' => $from, 'to' => $to)
            );
            return view('apartments.list')->with($data);
        }
        else{
            $apartments = $this->repository->getApartmentsInRadius($location["latitude"], $location["longitude"]);
            $apartmentObjects = [];
            foreach($apartments as $apartment){
                $apartment['username'] = $this->userRepository->getById($apartment["user_id"])->name;
                array_push($apartmentObjects, $apartment);
            }
            $data = array(
                'apartments' => $apartmentObjects,
                'location' => $location
            );
            return view('apartments.list')->with($data);
        }
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
            abort(404);
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

    public function getDirections(Request $request){
        if($request->apartment_id == null){
            abort(500);
        }
        $apartment = $this->repository->getById($request->apartment_id);
        if($apartment == null){
            abort(404);
        }
        return view('apartments.directions', compact('apartment'));
    }

    public function compareDeepValue($val1, $val2)
    {
        $res = strcmp($val1["id"], $val2["id"]);
        return $res;
    }
}
