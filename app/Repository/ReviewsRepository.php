<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 19.1.2018
 * Time: 21:55
 */

namespace App\Repository;

use App\Models\Review;
use App\Repository\Contracts\IReviewsRepository;



class ReviewsRepository implements IReviewsRepository
{

    public function getAll()
    {
        return Review::all();
    }

    public function getById(int $id)
    {
        return Review::where("id",$id)->first();
    }

    public function getByUserId(int $id)
    {
        return Review::where("user_id" ,$id)->get();
    }

    public function getByApartmentId(int $id)
    {
        return Review::where("apartment_id" ,$id)->get();
    }
}