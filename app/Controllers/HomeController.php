<?php

namespace App\Controllers;

use App\Models\EmployeesModel;

class HomeController extends BaseController
{
    public function index()
    {
        $model = new EmployeesModel();
        $employeeData = $model->orderBy('id', 'DESC')->findAll();
        $data = [
            "data" => $employeeData
        ];
        return view('index',$data);
    }
}
