<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 19.1.2018
 * Time: 21:55
 */

namespace App\Repository\Contracts;


interface IReviewsRepository
{
    public function getAll();
    public function getById(int $id);
    public function getByUserId(int $id);
    public function getByApartmentId(int $id);
}