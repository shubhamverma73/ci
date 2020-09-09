<?php
namespace App\Controllers;

use App\Models\Data_model;

class Home extends BaseController
{
	public function index()
	{
        // ================ Header and Footer are separate and Sidebar included in header ================
        $data = ['title' => 'Home Page'];
        echo view('includes/header', $data);
        echo view('index');
		echo view('includes/footer');
	}

    public function index_like_ci() {
        // ================= Header, Footer and Sidebar included in index page ===================
        $data = ['title' => 'Home Page'];
        echo view('home', $data);
    }

    public function index_like_laravel() {
        // ================ Header, Footer and Sidebar are in same page and direcrt call into laravel page =============
        $data = ['title' => 'Home Page'];
        echo view('laravel', $data);
    }

    public function index_old()
    {
        return view('welcome_message');
    }

}
