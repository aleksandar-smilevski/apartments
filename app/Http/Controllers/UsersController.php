<?php

namespace App\Http\Controllers;

use App\Repository\Contracts\IApartmentsRepository;
use App\Repository\Contracts\IReservationsRepository;
use App\Repository\Contracts\IReviewsRepository;
use App\Repository\Contracts\IUsersRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepository;
    protected $repository;
    protected $reservationsRepository;
    protected $reviewsRepository;
    public function __construct(IApartmentsRepository $apartmentsRepository, IReservationsRepository $reservationsRepository,IReviewsRepository $reviewsRepository, IUsersRepository $usersRepository)
    {
        $this->repository = $apartmentsRepository;
        $this->userRepository = $usersRepository;
        $this->reservationsRepository = $reservationsRepository;
        $this->reviewsRepository = $reviewsRepository;
    }

    public function index() {
        return $this->userRepository->getAll();
    }

    public function show($id) {
        $user = $this ->userRepository->getById($id);
        $reviews = $this -> reviewsRepository->getByUserId($id);
        $apartments = $this -> repository->getByUserId($id);
        $reservations = $this-> reservationsRepository->getByUserId($id);

        return view('users.show')
            ->with('user', $user)
            ->with('reviews', $reviews)
            ->with('apartments', $apartments)
            ->with('reservations', $reservations);
    }
}
