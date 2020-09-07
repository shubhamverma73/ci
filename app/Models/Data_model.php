<?php

namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Data_model extends Model {

	protected $table      = 'product';
	protected $primaryKey = 'id';
	protected $allowedFields = ['cat_id', 'name', 'dp_price', 'price', 'status', 'date', 'time', 'created_at'];
}