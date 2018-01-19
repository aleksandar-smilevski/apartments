<?php
/**
 * Created by PhpStorm.
 * User: Jona Dimovska
 * Date: 19.1.2018
 * Time: 15:07
 */

namespace App\Repository;

use App\Models\User;
use App\Repository\Contracts\IUsersRepository;

class UsersRepository implements IUsersRepository
{

    public function getAll()
    {
        return User::all();
    }

    public function getById(int $id)
    {
        return User::where("id", $id)->first();
    }
}