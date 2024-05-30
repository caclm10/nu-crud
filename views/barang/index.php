<?php
$title = "Barang";
?>

<?php include __DIR__ . "/../partials/header.php" ?>


<?php
$notif = $session->getFlashdata("notif");
?>
<?php if ($notif) : ?>
    <div class="notif notif--<?= $notif["type"] ?> block" data-notif>
        <?= $notif["message"] ?>

        <button type="button" class="notif__close" data-close>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
<?php endif ?>

<div class="card">
    <div class="card__header">
        <h1 class="card__title">Barang</h1>

        <button type="button" class="button button--primary" data-modal-trigger="create-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Barang</span>
        </button>
    </div>

    <div class="block">
        <form action="/index.php/barang" class="form-search">
            <div class="form-control">
                <span class="form-control__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>

                <input type="search" name="search" placeholder="Cari barang..." value="<?= $search ?>">
            </div>

            <button class="button button--gray-outline" data-submit-button="">
                Cari
            </button>
        </form>
    </div>

    <?php if (count($barang["items"]) > 0) : ?>

        <div class="table__wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($barang["items"] as $item) : ?>
                        <tr>
                            <td>
                                <div class="thumbnail thumbnail--48">
                                    <img src="<?= $item->foto ?>" alt="<?= $item->nama ?>">
                                </div>
                            </td>
                            <td><?= $item->nama ?></td>
                            <td>Rp<?= number_format($item->hargaBeli, 0, ',', '.'); ?></td>
                            <td>Rp<?= number_format($item->hargaJual, 0, ',', '.'); ?></td>
                            <td><?= $item->stok ?></td>
                            <td>
                                <div class="table__action">
                                    <button type="button" class="button button--icon button--sm button--primary-ghost" data-modal-trigger="edit-item" data-barang-id="<?= $item->id ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>

                                    </button>

                                    <button type="button" class="button button--icon button--sm button--danger-ghost" data-modal-trigger="delete-item" data-barang-id="<?= $item->id ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <?php if (count($barang["items"]) > 0) : ?>
            <nav class="pagination">
                <?php if ($barang["currentPage"] == 1) : ?>
                    <span class="pagination__item pagination__item--disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </span>
                <?php else : ?>
                    <a href="/index.php/barang?page=<?= $barang["currentPage"] - 1 ?><?= $search ? "&search=" . $search : "" ?>" class="pagination__item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </a>
                <?php endif ?>

                <?php
                $pages = [];
                if ($barang["totalPages"] > 5) {
                    $pages[] = 1;

                    $additionalPages = [];
                    if ($barang["currentPage"] > 4) {
                        $additionalPages = [
                            $barang["currentPage"] - 1,
                            $barang["currentPage"],
                        ];

                        if ($barang["currentPage"] < $barang["totalPages"]) {
                            $additionalPages[] = $barang["currentPage"] + 1;
                        }
                    } else {
                        for ($i = 2; $i <= 5; $i++) {
                            $additionalPages[] = $i;
                        }
                    }

                    if ($barang["totalPages"] - $barang["currentPage"] <= 3) {
                        for ($i = $barang["totalPages"] - 4; $i < $barang["totalPages"]; $i++) {
                            $additionalPages[] = $i;
                        }
                    }

                    $pages = array_unique(array_merge(
                        $pages,
                        $additionalPages,
                        [$barang["totalPages"]]
                    ));

                    sort($pages);
                } else {
                    for ($i = 1; $i <= $barang["totalPages"]; $i++) {
                        $pages[] = $i;
                    }
                }
                ?>

                <?php foreach ($pages as $key => $page) : ?>
                    <?php if ($page == $barang["currentPage"]) : ?>
                        <span class="pagination__item pagination__item--active">
                            <?= $page ?>
                        </span>
                    <?php else : ?>
                        <a href="/index.php/barang?page=<?= $page ?><?= $search ? "&search=" . $search : "" ?>" class="pagination__item">
                            <?= $page ?>
                        </a>
                    <?php endif ?>
                    <?php if ($page != $barang["totalPages"] && $pages[$key + 1] != $page + 1) : ?>
                        <span class="pagination__item pagination__item--disabled">
                            ...
                        </span>
                    <?php endif ?>
                <?php endforeach ?>

                <?php if ($barang["currentPage"] == $barang["totalPages"]) : ?>
                    <span class="pagination__item pagination__item--disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>

                    </span>
                <?php else : ?>
                    <a href="/index.php/barang?page=<?= $barang["currentPage"] + 1 ?><?= $search ? "&search=" . $search : "" ?>" class="pagination__item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                <?php endif ?>
            </nav>
        <?php endif ?>
    <?php else : ?>
        <div class="not-found">
            <p>
                <?= $search ? "Barang tidak ditemukan." : "Belum ada barang" ?>
            </p>
        </div>
    <?php endif ?>
</div>


<div class="modal <?= $errors->get("form") == "create" ? 'modal--active' : '' ?>" data-modal="create-item">
    <div class="modal__overlay" data-close></div>
    <div class="modal__content">
        <header class="modal__header">
            <h5 class="modal__title">Tambah Barang</h5>
        </header>

        <div class="modal__body">
            <form action="/index.php/barang/store" method="POST" id="tambah-barang-form" enctype="multipart/form-data">
                <div class="field">
                    <label for="nama" class="label">Nama</label>
                    <div class="form-control <?= $errors->has("nama") ? 'form-control--invalid' : '' ?>">
                        <input type="text" name="nama" id="nama" value="<?= $session->getOld("nama") ?>">
                    </div>
                    <?php if ($errors->has("nama")) : ?>
                        <p class="form-error-message">
                            <?= $errors->get("nama") ?>
                        </p>
                    <?php endif ?>
                </div>
                <div class="field">
                    <label for="harga-beli" class="label">Harga beli</label>
                    <div class="form-control <?= $errors->has("harga beli") ? 'form-control--invalid' : '' ?>">
                        <input type="number" name="harga_beli" id="harga-beli" value="<?= $session->getOld("harga_beli") ?>">
                    </div>
                    <?php if ($errors->has("harga beli")) : ?>
                        <p class="form-error-message">
                            <?= $errors->get("harga beli") ?>
                        </p>
                    <?php endif ?>
                </div>
                <div class="field">
                    <label for="harga-jual" class="label">Harga jual</label>
                    <div class="form-control <?= $errors->has("harga jual") ? 'form-control--invalid' : '' ?>">
                        <input type="number" name="harga_jual" id="harga-jual" value="<?= $session->getOld("harga_jual") ?>">
                    </div>
                    <?php if ($errors->has("harga jual")) : ?>
                        <p class="form-error-message">
                            <?= $errors->get("harga jual") ?>
                        </p>
                    <?php endif ?>
                </div>
                <div class="field">
                    <label for="stok" class="label">Stok</label>
                    <div class="form-control <?= $errors->has("stok") ? 'form-control--invalid' : '' ?>">
                        <input type="number" name="stok" id="stok" value="<?= $session->getOld("stok") ?>">
                    </div>
                    <?php if ($errors->has("stok")) : ?>
                        <p class="form-error-message">
                            <?= $errors->get("stok") ?>
                        </p>
                    <?php endif ?>
                </div>
                <div class="field">
                    <label class="label">Foto</label>
                    <div class="form-control <?= $errors->has("foto") ? 'form-control--invalid' : '' ?>">
                        <input type="file" name="foto" id="foto" data-form-image accept="image/*">
                    </div>

                    <div class="thumbnail thumbnail--210 hidden" data-form-image-preview>
                        <img src="">
                    </div>

                    <?php if ($errors->has("foto")) : ?>
                        <p class="form-error-message">
                            <?= $errors->get("foto") ?>
                        </p>
                    <?php endif ?>
                </div>
            </form>
        </div>

        <footer class="modal__footer">
            <button type="button" class="button button--gray-outline" data-close>
                Batal
            </button>
            <button class="button button--primary" form="tambah-barang-form" data-submit-button>
                Simpan
            </button>
        </footer>
    </div>
</div>

<div class="modal <?= $errors->get("form") == "edit" ? 'modal--active' : '' ?>" data-modal="edit-item">
    <div class="modal__overlay" data-close></div>
    <div class="modal__content">
        <header class="modal__header">
            <h5 class="modal__title">Edit Barang</h5>
        </header>

        <div class="modal__body overlay__wrapper">
            <div class="overlay overlay--center hidden" id="edit-item-loader">
                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="animate-spin">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 3a9 9 0 1 0 9 9" />
                </svg>
            </div>
            <div id="edit-item-form-wrapper">
                <form action="/index.php/barang/update/<?= $session->getOld("id_edit") ?>" method="POST" id="edit-item-form" enctype="multipart/form-data">
                    <div class="field">
                        <label for="nama-edit" class="label">Nama</label>
                        <div class="form-control <?= $errors->has("nama edit") ? 'form-control--invalid' : '' ?>">
                            <input type="text" name="nama" id="nama-edit" value="<?= $session->getOld("nama_edit") ?>">
                        </div>

                        <?php if ($errors->has("nama edit")) : ?>
                            <p class="form-error-message">
                                <?= $errors->get("nama edit") ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="field">
                        <label for="harga-beli-edit" class="label">Harga beli</label>
                        <div class="form-control <?= $errors->has("harga beli edit") ? 'form-control--invalid' : '' ?>">
                            <input type="number" name="harga_beli" id="harga-beli-edit" value="<?= $session->getOld("harga_beli_edit") ?>">
                        </div>

                        <?php if ($errors->has("harga beli edit")) : ?>
                            <p class="form-error-message">
                                <?= $errors->get("harga beli edit") ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="field">
                        <label for="harga-jual-edit" class="label">Harga jual</label>
                        <div class="form-control <?= $errors->has("harga jual edit") ? 'form-control--invalid' : '' ?>">
                            <input type="number" name="harga_jual" id="harga-jual-edit" value="<?= $session->getOld("harga_jual_edit") ?>">
                        </div>

                        <?php if ($errors->has("harga jual edit")) : ?>
                            <p class="form-error-message">
                                <?= $errors->get("harga jual edit") ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="field">
                        <label for="stok" class="label">Stok</label>
                        <div class="form-control <?= $errors->has("stok edit") ? 'form-control--invalid' : '' ?>">
                            <input type="number" name="stok" id="stok-edit" value="<?= $session->getOld("stok_edit") ?>">
                        </div>

                        <?php if ($errors->has("stok edit")) : ?>
                            <p class="form-error-message">
                                <?= $errors->get("stok edit") ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="field">
                        <label for="foto-edit" class="label">Foto</label>
                        <div class="form-control <?= $errors->has("foto edit") ? 'form-control--invalid' : '' ?>">
                            <input type="file" name="foto" id="foto-edit" accept="image/*" data-form-image>
                        </div>

                        <?php if ($errors->has("foto edit")) : ?>
                            <p class="form-error-message">
                                <?= $errors->get("foto edit") ?>
                            </p>
                        <?php endif ?>

                        <div class="thumbnail thumbnail--210 hidden" data-form-image-preview="<?= $session->getOld("foto_edit") ?>">
                            <img src="">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer class="modal__footer">
            <button type="button" class="button button--gray-outline" data-close>
                Batal
            </button>
            <button class="button button--primary" form="edit-item-form" data-submit-button>
                Simpan
            </button>
        </footer>
    </div>
</div>

<div class="modal modal--center" data-modal="delete-item">
    <div class="modal__overlay" data-close></div>
    <div class="modal__content">
        <header class="modal__header">
            <h5 class="modal__title">Hapus Barang</h5>
        </header>

        <div class="modal__body">
            <p id="delete-item-alert-message">Yakin ingin menghapus barang ini? Barang yang sudah dihapus tidak dapat dikembalikan.</p>
            <form action="/index.php/barang/destroy/8" method="POST" id="delete-item-form"></form>
        </div>

        <footer class="modal__footer">
            <button type="button" class="button button--gray-outline" data-close>
                Batal
            </button>
            <button class="button button--danger" form="delete-item-form" data-close data-submit-button>
                Hapus
            </button>
        </footer>
    </div>
</div>

<?php include __DIR__ . "/../partials/footer.php" ?>