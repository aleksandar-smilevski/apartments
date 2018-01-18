<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 14.1.2018
 * Time: 22:11
 */

namespace App\Repository\Contracts;


interface IReservationsRepository
{
    public function getAll();
    public function getById(int $id);
    public function getByApartmentId(int $apartment_id);
    public function getByUserId(int $user_id);
}