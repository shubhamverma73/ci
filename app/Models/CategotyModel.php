<?php

namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class CategoryModel extends Model {

	protected $table      = 'categories';
	protected $primaryKey = 'id';
	protected $DBGroup = 'default';
	protected $allowedFields = ['name', 'status'];
	protected $validationRules = [];
	protected $validationMessages = [];
}