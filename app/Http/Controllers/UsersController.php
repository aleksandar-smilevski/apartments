<?php

namespace App\Http\Controllers;

use App\Repository\Contracts\IUsersRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepository;
    public function __construct( IUsersRepository $usersRepository)
    {
        $this->userRepository = $usersRepository;
    }

    public function index() {
        return $this->userRepository->getAll();
    }

    public function show($id) {
        return $this->userRepository->getById($id);
    }
}
