<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 14.1.2018
 * Time: 14:31
 */
namespace App\Repository\Contracts;
use App\Models\Apartment;

interface IApartmentsRepository
{
    public function getAll();
    public function getById(int $id);
    public function create(Apartment $apartment);
    public function update(Apartment $apartment, $id);
    public function delete(int $id);


}