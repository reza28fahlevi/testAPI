<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeesModel;

class ApiEmployees extends ResourceController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new EmployeesModel();
    }

    // all employees
    public function index(){
        $data['employees'] = $this->model->orderBy('id', 'DESC')->findAll();

        return $this->respond($data);
    }
    // show employee
    public function show($id = null){
        $data = $this->model->where('id',$id)->first();

        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound("No employee found");
        }
    }
    // save data
    public function create()
    {
        $data = [
            'employee_name' => $this->request->getVar('employee_name',FILTER_SANITIZE_STRING),
            'employee_departement'  => $this->request->getVar('employee_departement',FILTER_SANITIZE_STRING),
        ];
        if(!$this->model->insert($data)){
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data saved',
                'id' => $this->model->insertID()
            ]
        ];

        return $this->respond($response);
    }
    // update data
    public function update($id = null)
    {
        $data = [
            'employee_name' => $this->request->getVar('employee_name',FILTER_SANITIZE_STRING),
            'employee_departement'  => $this->request->getVar('employee_departement',FILTER_SANITIZE_STRING),
        ];
        $this->model->update($id, $data);

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
        $data = $this->model->where('id', $id)->delete($id);

        if($data){
            $this->model->delete($id);
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