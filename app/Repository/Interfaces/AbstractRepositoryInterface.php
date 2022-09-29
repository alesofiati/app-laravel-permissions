<?php

namespace App\Repository\Interfaces;

interface AbstractRepositoryInterface
{

    public function find(int $id);

    public function findBy(array $attributes);

    public function create(array $attributes);

    public function update(int $id, array $attributes);

    public function all();

    public function paginate(int $perPage = 15);

    public function delete(int $id);

}
