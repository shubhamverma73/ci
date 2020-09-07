<?php
//http://www.expertphp.in/article/php-codeigniter-4-basic-crud-operation-with-mysql-database-with-example
namespace App\Controllers;

use App\Models\Data_model;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	function get_data(){
		helper(['url']);
		$model = new Data_model();
 
        $data['products'] = $model->orderBy('id', 'DESC')->findAll();        
        return view('product', $data);
	}    
 
    public function create() {    
        return view('create-product');
    }
 
    public function add() {  
 
        helper(['form', 'url']);         
        $model = new Data_model();
 
        $data = [ 
            		'cat_id' => '1',
            		'name' => $this->request->getVar('name'),
            		'dp_price'  => $this->request->getVar('dp_price'),
            		'price'  => $this->request->getVar('price'),
            		'status'  => '1',
            		'date'  => date('Y-m-d'),
            		'time'  => date('H:i:s'),
            		'created_at'  => date('Y-m-d H:i:s'),
            ]; 
        $save = $model->insert($data); 
        return redirect()->to( 'get-data');
    }
 
    public function edit($id = null) {
    
        $model = new Data_model();
        $data['post'] = $model->find($id);
        return view('edit-post', $data);
    }
 
    public function update() {  
 
        helper(['form', 'url']);         
        $model = new Data_model(); 
        $id = $this->request->getVar('id');        
        $data = [ 
                    'name' => $this->request->getVar('name'),
                    'dp_price'  => $this->request->getVar('dp_price'),
                    'price'  => $this->request->getVar('price'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
 
        $save = $model->update($id,$data); 
        return redirect()->to('get_data');
    }
 
    public function delete($id = null) {
 
        $model = new Data_model(); 
        $model->where('id', $id)->delete();      
        return redirect()->to('get_data');
    }

	//--------------------------------------------------------------------

}
