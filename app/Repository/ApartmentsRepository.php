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
        return Apartment::where("id", $id)->get();
    }
}