<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <form action="" method="post">
                <input type="hidden" name="id" id="id" value="<?= $menu['id']; ?>">
                <div class="form-group">
                    <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name" value="<?= $menu['menu']; ?>">
                    <?= form_error('menu', '<small class="text-danger">', '<small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
</div>
</div>