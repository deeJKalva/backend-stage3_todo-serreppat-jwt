<?php

namespace App\Services;

use App\Repositories\TodoRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAll()
    {
        $todo = $this->todoRepository->getAll();
        return $todo;
    }

    public function store($data) : Object
    {
        $validator = Validator::make($data, [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->todoRepository->store($data);
        return $result;
    }

    public function getByName($title)
    {
        return $this->todoRepository->getByName($title);
    }

    public function updateTodo($data, $title)
    {
        $validator = Validator::make($data, [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $todo = $this->todoRepository->update($data, $title);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to update todo');
        }

        DB::commit();
        return $todo;
    }

    public function deleteByName($title)
    {
        DB::beginTransaction();
        try {
            $todo = $this->todoRepository->delete($title);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete todo');
        }

        DB::commit();
        return $todo;
    }
}