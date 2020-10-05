<?php
namespace App\Controllers;

use App\Models\Data_model;
use Config\Database;

class Test extends BaseController
{
    function get_data(){
        helper(['url']);
        $model = new Data_model();
 
        $data['products'] = $model->orderBy('id', 'DESC')->findAll();  
        //echo $this->db->getLastQuery();      
        return view('product', $data);
    }    


    function get_data_query_builer(){
        helper(['url']);
        $query = $this->db->table('product')->get();
        $data['products'] = $query->getResultArray();
        //echo $this->db->getLastQuery();
        return view('product', $data);
    }
 
    public function create() {    
        return view('create-product');
    }
 
    public function add() {  
 
        helper(['form', 'url']);         
        $model = new Data_model();

        $val = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
        ]);

        if (!$val) {
            //echo view('create-product', ['validation' => $this->validator]);
            return redirect()->back()->withInput()->with('validation', $this->validator);
        } else { 
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
            $model->transBegin();
            $save = $model->insert($data); 
            $lastId = $model->insertID();
            if(empty($lastId)) {
                $model->transRollback();
                return redirect()->route('create');
            } else { 
                $model->transCommit();           
                return redirect()->route('get-data');
            }
        }
    }
 
    public function edit($id = null) {
    
        $model = new Data_model();
        $data['post'] = $model->find($id);
        echo view('edit-post', $data);
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
 
        //$save = $model->update($id,$data); 
        $save = $model->where('id', $id)->update($id,$data); 
        return redirect()->route('get-data');
    }
 
    public function delete($id = null) {
 
        $model = new Data_model(); 
        $model->where('id', $id)->delete();      
        return redirect()->route('get-data');
    }
    //--------------------------------------------------------------------
}
