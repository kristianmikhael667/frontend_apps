<!-- Header -->
<?= $this->include('Views/templates/admin/dashboard/head') ?>

<div class="app horizontal-menu align-content-stretch d-flex flex-wrap">
    <div class="app-container">
        <div class="search container">
            <form>
                <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
            </form>
            <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
        </div>

        <!-- Navbar -->
        <?= $this->include('Views/templates/admin/dashboard/navbar') ?>

        <!-- Sidebar -->
        <?= $this->include('Views/templates/admin/dashboard/sidebar') ?>

        <div class="app-content">
            <div class="content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="page-description">
                                <h1>List Provider</h1>
                            </div>
                            <div class="page-description-actions">
                               
                                <div class="modal fade" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="additems" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="additems">Tambah Items Games</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url(); ?>admin/product/create" method="POST" enctype="multipart/form-data">

                                                <div class="modal-body">
                                                    <p></p>
                                                    <div class="alert alert-custom" role="alert">
                                                        <div class="example-content">
                                                            <div class="col-md-12"> <!-- Perubahan pada kelas ini -->
                                                                <legend class="col-form-label col-sm-12 pt-0"><b>Pilih Game</b></legend>
                                                                <div class="col-sm-12">
                                                                    <?php foreach ($results as $result) : ?>
                                                                        <div class="form-check form-check-inline"> <!-- Perubahan pada kelas ini -->
                                                                            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="<?= htmlspecialchars(json_encode($result)) ?>" checked>
                                                                            <label class="form-check-label" for="gridRadios1">
                                                                            <span class="d-inline-block w-100 text-truncate">sss</span>

                                                                            </label>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable1" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Provider ID</th>
                                                    <th>Prefix Code</th>
                                                    <th>Name Provider</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($results)) : ?>
                                            <?php foreach ($results as $num => $result) : ?>
                                                <tr>
                                                    <td><?= $num+1 ?></td>
                                                    <td><?= $result->provider_id ?></td>
                                                    <td><?= $result->prefix_code ?></td>
                                                    <td><?= $result->name_provider ?></td>
                                                    <td><?= $result->status == 1 ? "Active" : "Non Active" ?></td>
                                                    <td><?= $result->created_at ?></td>
                                                    <td><?= $result->updated_at ?></td>
                                                    
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="12">Tidak ada Transaction yang tersedia.</td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Javascripts -->
<?= $this->include('Views/templates/admin/dashboard/script') ?>

</body>

</html>