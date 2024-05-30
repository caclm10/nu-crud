<?php

namespace App\Models;

class BarangModel extends Model
{
    public function __construct(
        public int $id = 0,
        public string $nama = "",
        public int $hargaBeli = 0,
        public int $hargaJual = 0,
        public int $stok = 0,
        public string $foto = "",
    ) {
        parent::__construct();
    }

    /**
     * 
     * @return BarangModel[]
     */
    public function all(): array
    {
        $data = [];
        $result = $this->db->conn->query(
            "SELECT id, nama, harga_beli, harga_jual, stok, foto FROM barang"
        );

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = new BarangModel(
                    $row["id"],
                    $row["nama"],
                    $row["harga_beli"],
                    $row["harga_jual"],
                    $row["stok"],
                    $row["foto"]
                );
            }
        }

        return $data;
    }

    /**
     * 
     * @return BarangModel[]
     */
    public function paginate(int $page = 1, int $size = 5, string $search = ""): array
    {
        $data = [
            "items" => [],
            "currentPage" => $page,
            "currentStart" => (($page - 1) * $size) + 1,
            "totalPages" => 0,
        ];
        $result = $this->db
            ->conn
            ->execute_query(
                "SELECT id, nama, harga_beli, harga_jual, stok, foto FROM barang WHERE nama LIKE ? LIMIT ? OFFSET ?",
                ["%" . $search . "%", $size, ($page - 1) * $size]
            );

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data["items"][] = new BarangModel(
                    $row["id"],
                    $row["nama"],
                    $row["harga_beli"],
                    $row["harga_jual"],
                    $row["stok"],
                    $row["foto"]
                );
            }
        }

        $result = $this->db
            ->conn
            ->execute_query("SELECT id AS NumberOfBarang FROM barang WHERE NAMA LIKE ?", ["%" . $search . "%"]);

        $data["totalPages"] = (int) ceil($result->num_rows / $size);

        return $data;
    }

    public function find(int $id): self
    {
        $result = $this->db
            ->conn
            ->execute_query("SELECT id, nama, harga_beli, harga_jual, stok, foto FROM barang WHERE id = ?", [$id]);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->fill([
                    "id" => $row["id"],
                    "nama" => $row["nama"],
                    "hargaBeli" => $row["harga_beli"],
                    "hargaJual" => $row["harga_jual"],
                    "stok" => $row["stok"],
                    "foto" => $row["foto"]
                ]);
            }
        }

        return $this;
    }

    public function insert(): self
    {
        $stmt = $this->db->conn->prepare("INSERT INTO barang (nama, harga_beli, harga_jual, stok, foto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $this->nama, $this->hargaBeli, $this->hargaJual, $this->stok, $this->foto);

        $stmt->execute();
        $this->id = $stmt->insert_id;

        $stmt->close();

        return $this;
    }

    public function update(int $id): self
    {
        $result = $this->db
            ->conn
            ->execute_query(
                "UPDATE barang SET nama = ?, harga_beli = ?, harga_jual = ?, stok = ?, foto = ? WHERE id = ?",
                [$this->nama, $this->hargaBeli, $this->hargaJual, $this->stok, $this->foto, $id]
            );

        if (is_bool($result)) {
            if ($result) $this->id = $id;
        } else if ($result->num_rows > 0) {
            $this->id = $id;
        }

        return $this;
    }

    public function delete()
    {
        $this->db
            ->conn
            ->execute_query("DELETE FROM barang WHERE id = ?", [$this->id]);
    }
}
