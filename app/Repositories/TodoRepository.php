<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository
{
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getAll() : Object
    {
        $todo = $this->todo->get();
        return $todo;
    }

    public function store($data) : Object
    {
        $newData = new $this->todo;
        $newData->title = $data['title'];
        $newData->save();
        return $newData->fresh();
    }

    public function getByName($title)
    {
        return $this->todo->where('title', $title)->get();
    }

    public function update($data, $title)
    {
        // $todo = $this->todo->where('title', $title)->first();
        // $todo->title = $data['title'];
        // $todo->save();
        // return $todo;

        $todo = $this->todo->find($title);
        $todo->title = $data['title'];
        $todo->update();
        return $todo;
    }

    public function delete($title)
    {
        $todo = $this->todo->find($title);
        $todo->delete();
        return $todo;
    }
}