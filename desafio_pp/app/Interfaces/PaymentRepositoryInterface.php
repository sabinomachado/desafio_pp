<?php

namespace App\Interfaces;

interface PaymentRepositoryInterface
{
    public function create(array $data): string;
    public function findById(string $id): object|null;
}
