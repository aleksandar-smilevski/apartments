<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 14.1.2018
 * Time: 14:33
 */
namespace App\Repository;

use App\Models\Apartment;
use App\Repository\Contracts\IApartmentsRepository;
use Illuminate\Support\Facades\DB;

class ApartmentsRepository implements IApartmentsRepository
{

    public function getAll()
    {
        return Apartment::all();
    }

    public function getById(int $id)
    {
        return Apartment::where("id", $id)->first();
    }

    public function create(Apartment $apartment)
    {
        $apartment = $apartment->save();
        return $apartment;
    }

    public function update(Apartment $apartment, $id)
    {
        $oldApartment = Apartment::find($id);
        if($oldApartment == null){
            return false;
        }

        $oldApartment->name = $apartment->name;
        $oldApartment->description = $apartment->description;
        $oldApartment->longitude = $apartment->longitude;
        $oldApartment->latitude = $apartment->latitude;
        $oldApartment->address = $apartment->address;
        $oldApartment->price = $apartment->price;
        $oldApartment->user_id = $apartment->user_id;
        return $oldApartment->update();
    }

    public function delete(int $id)
    {
        $apartment = Apartment::find($id);


        $apartment->delete();

    }
    public function getAvailableApartmentsFromIdsArray($ids){
        return Apartment::whereIn('id',$ids)->get();
    }


    public function getByUserId(int $user_id)
    {
        return Apartment::where("user_id", $user_id)->get();
    }

    public function getApartmentsInRadius($lat, $long, $radius = 10)
    {
        $bounds = $this->getBounds($lat, $long, $radius);
        return $apartmentsInRadius = Apartment::whereBetween('latitude', array($bounds->minLat, $bounds->maxLat))
            ->whereBetween('longitude', array($bounds->minLong,$bounds->maxLong))->get();
    }

    //SE UBIV DODEKA DA DOJDAM DO OVA, GLUP SUM, ZNAM, HELP ME!
    public function getAvailableApartments($from, $to, $lat, $lon, $radius = 10){
        $bounds = $this->getBounds($lat, $lon, $radius);
        $results = DB::select('SELECT distinct a.* FROM apartments.apartments as a left join reservations as r on a.id = r.apartment_id where (coalesce(:from not between r.from and r.to)
          and coalesce(:to not between r.from and r.to) or r.id is null) and (a.latitude between :minLat and :maxLat and a.longitude between :minLong and :maxLong)', ['from' => $from, 'to' => $to, 'minLat' => $bounds->minLat, 'maxLat' => $bounds->maxLat, 'minLong' => $bounds->minLong, 'maxLong' => $bounds->maxLong]);
        $results = json_decode(json_encode($results), true);
        return $results;
    }

    //Calculates a rectangle which represents the bounds of 10 kilometeres
    private function getBounds($latitude, $longitude, $kilometer)
    {
        $radiusOfEarthKM  = 6371;
        $latitudeRadians  = deg2rad($latitude);
        $longitudeRadians = deg2rad($longitude);
        $distance         = $kilometer / $radiusOfEarthKM;

        $deltaLongitude = asin(sin($distance) / cos($latitudeRadians));

        $bounds = new \stdClass();

        $bounds->minLat  = rad2deg($latitudeRadians  - $distance)   ;
        $bounds->maxLat  = rad2deg($latitudeRadians  + $distance);
        $bounds->minLong = rad2deg($longitudeRadians - $deltaLongitude);
        $bounds->maxLong = rad2deg($longitudeRadians + $deltaLongitude);

        return $bounds;
    }
}