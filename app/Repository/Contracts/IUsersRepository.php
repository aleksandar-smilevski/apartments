<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 19.1.2018
 * Time: 15:07
 */

namespace App\Repository\Contracts;


interface IUsersRepository
{
    public function getAll();
    public function getById(int $id);
}