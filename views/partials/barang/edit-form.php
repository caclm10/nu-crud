<form action="/index.php/barang/update/<?= $barang->id ?>" method="POST" id="edit-item-form" enctype="multipart/form-data">
    <div class="field">
        <label for="nama-edit" class="label">Nama</label>
        <div class="form-control">
            <input type="text" name="nama" id="nama-edit" value="<?= $barang->nama ?>">
        </div>
    </div>
    <div class="field">
        <label for="harga-beli-edit" class="label">Harga beli</label>
        <div class="form-control">
            <input type="number" name="harga_beli" id="harga-beli-edit" value="<?= $barang->hargaBeli ?>">
        </div>
    </div>
    <div class="field">
        <label for="harga-jual-edit" class="label">Harga jual</label>
        <div class="form-control">
            <input type="number" name="harga_jual" id="harga-jual-edit" value="<?= $barang->hargaJual ?>">
        </div>
    </div>
    <div class="field">
        <label for="stok" class="label">Stok</label>
        <div class="form-control">
            <input type="number" name="stok" id="stok-edit" value="<?= $barang->stok ?>">
        </div>
    </div>
    <div class="field">
        <label for="foto-edit" class="label">Foto</label>
        <div class="form-control">
            <input type="file" name="foto" id="foto-edit" accept="image/*" data-form-image>
        </div>

        <div class="thumbnail thumbnail--210 hidden" data-form-image-preview="<?= $barang->foto ?>">
            <img src="">
        </div>
    </div>
</form>