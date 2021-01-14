<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Services\ImageService;


class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function show($id)
    {
        return Employee::findOrFail($id);
    }

    public function store(EmployeeStoreRequest $request, ImageService $image)
    {
        $fields = [
            'name' => $request->name,
            'surname' => $request->surname,
            'photo' => $image->upload($request->photo),
            'comment' => $request->comment
        ];

        $employee = Employee::create($fields);

        return $employee;
    }

    public function edit($id,EmployeeUpdateRequest $request, ImageService $image)
    {
        $fields = [
            'name' => $request->name,
            'surname' => $request->surname,
            'comment' => $request->comment
        ];

        $employee = Employee::findOrFail($id);

        if($request->photo){
            array_merge($fields,['photo' => $image->upload($request->photo)]);
            $image->remove($employee->photo);
        }

        $employee->update($fields);

        return $employee;
    }

    public function delete($id, ImageService $image)
    {
        $employee = Employee::findOrFail($id);
        $image->remove($employee->photo);
        return $employee->delete();
    }


}
