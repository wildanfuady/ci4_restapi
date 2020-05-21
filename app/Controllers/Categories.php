<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Categories extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\Category_model';

	public function index()
	{
		return $this->respond($this->model->findAll(), 200);
    }

    public function create()
    {
        $validation =  \Config\Services::validation();

        $name   = $this->request->getPost('category_name');
        $status = $this->request->getPost('category_status');
        
        $data = [
            'category_name' => $name,
            'category_status' => $status
        ];
        
        if($validation->run($data, 'category') == FALSE){
            $response = [
                'status' => 500,
                'error' => true,
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 500);
        } else {
            $simpan = $this->model->insertCategory($data);
            if($simpan){
                $msg = ['message' => 'Created category successfully'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg,
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function show($id = NULL)
    {
        $get = $this->model->getCategory($id);
        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg,
            ];
        }
        return $this->respond($response, $code);
    }

    public function edit($id = NULL)
    {
        $get = $this->model->getCategory($id);
        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg,
            ];
        }
        return $this->respond($response, $code);
    }

    public function update($id = NULL)
    {
        $validation =  \Config\Services::validation();

        // $name   = $this->request->getRawInput('category_name');
        // $status = $this->request->getRawInput('category_status');

        $data = $this->request->getRawInput();

        // $data = [
        //     'category_name' => $name,
        //     'category_status' => $status 
        // ];

        if($validation->run($data, 'category') == FALSE){

            $response = [                                                                                       
                'status' => 500,
                'error' => true,
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 500);

        } else {

            $simpan = $this->model->updateCategory($data,$id);
            if($simpan){
                $msg = ['message' => 'Updated category successfully'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg,
                ];
                return $this->respond($response, 200);
            } 
            
        }
    }

    public function delete($id = NULL)
    {
        $hapus = $this->model->deleteCategory($id);
        if($hapus){
            $code = 200;
            $msg = ['message' => 'Deleted category successfully'];
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $msg,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $msg,
            ];
        }
        return $this->respond($response, $code);
    }
    
}
