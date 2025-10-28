<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'due_date', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title' => 'required|max_length[255]|min_length[5]',
        'description' => 'max_length[255]',
        'due_date' => 'permit_empty|valid_date',
    ];
    protected $validationMessages   = [
        'title' => [
            'required' => 'El titulo es obligatorio.',
            'max_length' => 'El titulo no puede exceder los 255 caracteres.',
            'min_length' => 'el titulo debe tener al menos 5 caracteres.',
        ],
        'description' => [
            'max_length' => 'La descripción no puede exceder los 255 caracteres.',
        ],
        'due_date' => [
            'valid_date' => 'Debe ser una fecha válida.',
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
