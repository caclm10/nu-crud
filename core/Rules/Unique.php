<?php

namespace Core\Rules;

use Core\Database;

class Unique extends Rule
{
    public function __construct(
        protected string $table,
        protected string $column,
        protected int $ignoreId = 0,
    ) {
    }
    public function validate(): string
    {
        $message = "Field " . $this->attribute . " dengan nilai yang sama sudah ada.";

        $db = Database::getInstance();
        $result = $db->conn
            ->execute_query(
                "SELECT {$this->column} FROM {$this->table} WHERE LOWER({$this->column})=? AND id != ?",
                [strtolower($this->value), $this->ignoreId]
            );

        if ($result->num_rows > 0) {
            return $message;
        }

        return "";
    }
}
