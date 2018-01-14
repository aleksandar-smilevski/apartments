<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 14.1.2018
 * Time: 14:31
 */
namespace App\Repository\Contracts;
interface IApartmentsRepository
{
    public function getAll();
    public function getById(int $id);

}