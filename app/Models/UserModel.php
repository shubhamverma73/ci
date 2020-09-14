<?php

namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class UserModel extends Model {

	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $DBGroup = 'default';
	protected $allowedFields = ['username', 'email', 'password', 'name', 'status', 'created_at', 'modified_at'];
	protected $validationRules = [];
	protected $validationMessages = [];
}