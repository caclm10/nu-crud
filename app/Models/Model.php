<?php

namespace App\Models;

use Core\Database;

class Model
{
    public Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function fill(array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
