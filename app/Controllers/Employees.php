<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeesModel;

class Employees extends BaseController
{
    use ResponseTrait;

    // all employees
    public function index(){
        $model = new EmployeesModel();
        $data['employees'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
    // show employee
    public function show($id = null){
        $model = new EmployeesModel();
        $data = $model->where('id',$id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound("No employee found");
        }
    }
    // save data
    public function create()
    {
        $model = new EmployeesModel();
        $data = $this->request->getPost();
        if(!$model->save($data)){
            return $this->fail($model->errors());
        }
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data saved'
            ]
        ];
        return $this->respond($response);
    }
    // update data
    public function update($id = null)
    {
        $model = new EmployeesModel();
        $id = $this->request->getVar('id');
        $data = [
            'employee_name' => $this->request->getVar('name'),
            'employee_departement'  => $this->request->getVar('email'),
        ];
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Employee updated successfully'
            ]
        ];
        return $this->respond($response);
    }
    // delete data
    public function delete($id = null)
    {
        $model = new EmployeesModel();
        $data = $model->where('id', $id)->delete($id);
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No employee found');
        }
    }
}