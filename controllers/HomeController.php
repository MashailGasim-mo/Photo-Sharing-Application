<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Photo.php';

class HomeController extends Controller
{
    private User $userModel;
    private Photo $photoModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->photoModel = new Photo();
    }

    public function index(): void
    {
        $users = $this->userModel->count();
        $photos = $this->photoModel->count();

        $this->view('home', [
            'usersCount' => $users,
            'photosCount' => $photos
        ]);
    }
}