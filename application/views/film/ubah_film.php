<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php if(validation_errors()){?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors();?>
            </div>
            <?php }?>
            <?= $this->session->flashdata('pesan'); ?>


            <!-- KOnten -->
            <form action="<?= base_url('film/ubahfilm'); ?>" method="post" enctype="multipart/form-data">
                <div class='row'>
                    <div class="col-sm-3">
                        <img src="<?= base_url('assets/img/upload/') . $film['image']; ?>" class="img-thumbnail" alt="">
                    </div>
                    <div class='col-sm-9'>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="judul_film"
                                    name="judul_film" placeholder="Masukkan Judul Film"
                                    value="<?= $film['judul_film']; ?>">
                            </div>
                            <div class="form-group">
                                <select name="id_kategori" class="form-control form-control-user">
                                    <option value="<?= $k; ?>">Data tidak berubah...</option>
                                    <?php foreach ($kategori as $k) { ?>
                                    <option value="<?= $k['id'];?>"><?= $k['kategori'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="sutradara"
                                    name="sutradara" placeholder="Masukkan nama sutradara" value='<?= $film['sutradara']; ?>'>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="studio" name="studio" placeholder="Masukkan nama studio" value='<?= $film['studio']; ?>'>
                            </div>
                            <div class="form-group">
                                <select name="tahun" class="form-control form-control-user">
                                    <option value="<?= $film['tahun_terbit']; ?>">Data tidak berubah...</option>
                                    <?php for ($i=date('Y'); $i > 1000 ; $i--) { ?>
                                    <option value="<?= $i;?>"><?= $i;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="isbn" name="isbn"
                                    placeholder="Masukkan ISBN" value='<?= $film['isbn']; ?>'>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="stok" name="stok"
                                    placeholder="Masukkan nominal stok" value='<?= $film['stok']; ?>'>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control form-control-user" id="image" name="image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back(-1)"><i
                                    class="fas fa-ban"></i>Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                                Update</button>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->