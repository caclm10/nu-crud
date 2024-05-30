<?php

namespace Core;

use Support\Singleton;

class Database extends Singleton
{
    public \mysqli $conn;

    protected function __construct(
        protected string $host = "localhost",
        protected int $port = 3306,
        protected string $username = "root",
        protected string $password = "",
        protected string $db = "nutech_crud",
    ) {
    }

    public function connect(): void
    {
        // Create connection
        $conn = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->db,
            $this->port
        );

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $this->conn = $conn;
    }

    public static function getInstance(): self
    {
        return parent::getInstance();
    }
}
