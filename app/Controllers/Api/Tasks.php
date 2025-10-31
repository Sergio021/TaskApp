<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Tasks extends ResourceController
{
    protected $modelName = 'App\Models\TaskModel';
    protected $format    = 'json';

    public function index()
    {
        $tasks = $this->model->findAll();
        return $this->respond($tasks);
    }

    public function show($id = null)
    {
        $tasks = $this->model->find($id);
        if (!$tasks) {
            return $this->failNotFound('Tarea no encontrada');
        }
        return $this->respond($tasks);
    }

    public function create()
    {   
        $data = $this->request->getJSON(true);
        if(!$data){
            return $this->failValidationErrors("existen campos vacios, favor de verificar su información");
        }
        if(!$this->model->insert($data)){
            return $this->failValidationErrors($this->model->errors());
        }
        $info = [
            'error' => false,
            'message' => 'Tarea creada correctamente',
        ];
        return $this->respondCreated($info);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if($this->model->find($id) === null){
            return $this->failNotFound('Tarea no encontrada');
        }
        if(!$this->model->update($id, $data)){
            return $this->failValidationErrors($this->model->errors());
        }
        $info = [
            'error' => false,
            'message' => 'Tarea actualizada correctamente',
        ];
        return $this->respond($info);
    }

    public function delete($id = null)
    {
        $tasks = $this->model->find($id);
        if (!$tasks) {
            return $this->failNotFound('Tarea no encontrada');
        }
        if(!$this->model->delete($id)){
            return $this->failServerError('No se pudo eliminar la tarea');
        }
        $info = [
            'error' => false,
            'message' => 'Tarea eliminada correctamente',
        ];
        return $this->respondDeleted($info);
    }
}
