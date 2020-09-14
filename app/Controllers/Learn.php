<?php
namespace App\Controllers;

use App\Models\UserModel;

class Learn extends BaseController
{
	public function index()
	{
        $UserModel = new UserModel();
        $data = [
                    'username' => 'vishwash',
                    'email' => 'vishwash@gmail.com',
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'name' => 'Vishwash',
                    'status' => 'Approved',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
        $UserModel->insert($data);
        $lastId = $UserModel->insertID();
        echo $lastId;
	}

    function get() {
        $UserModel = new UserModel();
        $singleData = $UserModel->find(1);
        $allData = $UserModel->findAll();
        echo '<pre>';
        print_r($singleData);
        print_r($allData);
    }

    function update() {
        $UserModel = new UserModel();
        $data = [
                    'name' => 'Vishwash V',
                    'modified_at' => date('Y-m-d H:i:s'),
                ];
        $UserModel->where('email', 'vishwash@gmail.com')->update('2', $data);
        echo $UserModel->affectedRows() ? 1 : 0;
    }

    function delete() {
        $UserModel = new UserModel();
        $UserModel->where('id', '4')->delete();
        echo $UserModel->affectedRows() ? 1 : 0;
    }

    function constant_define() {
        echo env('app.baseURL'); //Getting from .env file
    }

}
