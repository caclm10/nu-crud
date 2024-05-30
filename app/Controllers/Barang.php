<?php

namespace App\Controllers;

use App\Models\BarangModel;
use Core\Rules\MaxFileSize;
use Core\Rules\Numeric;
use Core\Rules\OnlyImage;
use Core\Rules\Required;
use Core\Rules\RequiredFile;
use Core\Rules\Unique;

class Barang extends Controller
{
    protected BarangModel $model;

    public function __construct()
    {
        $this->model = new BarangModel();
    }

    public function index(): string
    {
        $page = (int) $this->request->getQuery("page", "1");
        $search = $this->request->getQuery("search", "");

        $errors = $this->session->getValidationErrors();

        $barang = $this->model->paginate($page, 5, $search);

        return $this->render("barang/index", [
            "errors" => $errors,
            "barang" => $barang,
            "search" => $search
        ]);
    }

    public function store(): never
    {
        $payload = $this->request->getPost();
        $picture = $this->request->getFile("foto");

        $errors = $this->validation->validate([
            "nama" => [
                "value" => $payload["nama"],
                "rules" => [
                    new Required,
                    new Unique("barang", "nama")
                ]
            ],
            "harga beli" => [
                "value" => $payload["harga_beli"],
                "rules" => [
                    new Required,
                    new Numeric
                ]
            ],
            "harga jual" => [
                "value" => $payload["harga_jual"],
                "rules" => [
                    new Required,
                    new Numeric
                ]
            ],
            "stok" => [
                "value" => $payload["stok"],
                "rules" => [
                    new Required,
                    new Numeric
                ]
            ],
            "foto" => [
                "value" => $picture,
                "rules" => [
                    new RequiredFile,
                    new OnlyImage,
                    new MaxFileSize,
                ]
            ],
        ]);

        if ($errors->any()) {
            $errors->add("form", "create");
            $this->session->setFlashdata("validation_errors", $errors);
            $this->session->setOld($payload);
        } else {
            $pictureExt = pathinfo($picture["name"], PATHINFO_EXTENSION);
            $path = "/uploads/images/" . time() . "_" . bin2hex(random_bytes(10)) . "." . $pictureExt;

            move_uploaded_file(
                $picture["tmp_name"],
                __DIR__ . "/../../public" . $path
            );

            $this->model->fill([
                "nama" => $payload["nama"],
                "hargaJual" => (int) $payload["harga_jual"],
                "hargaBeli" => (int) $payload["harga_beli"],
                "stok" => (int) $payload["stok"],
                "foto" => $path
            ]);

            $this->model->insert();

            $this->session->setFlashdata("notif", [
                "type" => "success",
                "message" => "Berhasil menambah data barang."
            ]);
        }


        $this->response->redirect(
            $this->session->get("prev_url", "/barang")
        );
    }

    public function edit(string $id)
    {
        $this->model->find((int) $id);

        return $this->render("partials/barang/edit-form", [
            "barang" => $this->model
        ]);
    }

    public function update(string $id): never
    {
        $this->model->find((int) $id);

        if (!$this->model->id) {
            $this->response->redirect(
                $this->session->get("prev_url", "/barang")
            );
        }


        $payload = $this->request->getPost();
        $picture = $this->request->getFile("foto");

        $errors = $this->validation->validate([
            "nama edit" => [
                "value" => $payload["nama"],
                "attribute" => "nama",
                "rules" => [
                    new Required,
                    new Unique("barang", "nama", (int) $id)
                ]
            ],
            "harga beli edit" => [
                "value" => $payload["harga_beli"],
                "attribute" => "harga beli",
                "rules" => [
                    new Required,
                    new Numeric
                ]
            ],
            "harga jual edit" => [
                "value" => $payload["harga_jual"],
                "attribute" => "harga jual",
                "rules" => [
                    new Required,
                    new Numeric
                ]
            ],
            "stok edit" => [
                "value" => $payload["stok"],
                "attribute" => "stok",
                "rules" => [
                    new Required,
                    new Numeric
                ]
            ],
            "foto edit" => [
                "value" => $picture,
                "attribute" => "foto",
                "rules" => [
                    new OnlyImage,
                    new MaxFileSize,
                ]
            ],
        ]);

        $oldPath = $this->model->foto;

        if ($errors->any()) {
            $errors->add("form", "edit");
            $this->session->setFlashdata("validation_errors", $errors);
            $this->session->setOld([
                "id_edit" => $id,
                "nama_edit" => $payload["nama"],
                "harga_beli_edit" => $payload["harga_beli"],
                "harga_jual_edit" => $payload["harga_jual"],
                "stok_edit" => $payload["stok"],
                "foto_edit" => $oldPath
            ]);
        } else {
            $path = "";

            if ($picture["name"]) {
                $pictureExt = pathinfo($picture["name"], PATHINFO_EXTENSION);
                $path = "/uploads/images/" . time() . "_" . bin2hex(random_bytes(10)) . "." . $pictureExt;

                move_uploaded_file(
                    $picture["tmp_name"],
                    __DIR__ . "/../../public" . $path
                );
            }

            $this->model->fill([
                "nama" => $payload["nama"],
                "hargaJual" => (int) $payload["harga_jual"],
                "hargaBeli" => (int) $payload["harga_beli"],
                "stok" => (int) $payload["stok"],
                "foto" => $path ?: $oldPath
            ]);

            $this->model->update($id);

            if ($path) {
                unlink(
                    __DIR__ . "/../../public" . $oldPath
                );
            }

            $this->session->setFlashdata("notif", [
                "type" => "success",
                "message" => "Berhasil memperbarui data barang."
            ]);
        }


        $this->response->redirect(
            $this->session->get("prev_url", "/barang")
        );
    }

    public function destroy(string $id): never
    {
        $this->model->find($id);

        $picture = $this->model->foto;

        $this->model->delete();

        if ($picture) {
            unlink(
                __DIR__ . "/../../public" . $picture
            );
        }

        $this->session->setFlashdata("notif", [
            "type" => "success",
            "message" => "Berhasil menghapus data barang."
        ]);

        $this->response->redirect(
            $this->session->get("prev_url", "/barang")
        );
    }
}
