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
        return $oldApartment->update();
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
    public function getAvailableApartmentsFromIdsArray($ids){
        return Apartment::whereIn('id',$ids)->get();
    }


    public function getByUserId(int $user_id)
    {
        return Apartment::where("user_id", $user_id)->get();
    }
}