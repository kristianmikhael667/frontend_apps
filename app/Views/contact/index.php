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
        <!-- Notif Websocket -->
        <div id="messages" class="alert alert-primary alert-style-light" role="alert"></div>

            <div class="content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="page-description">
                                <h1>List Contact</h1>
                            </div>
                            <div class="page-description-actions">
                                <button type="button" class="btn btn-primary m-b-sm" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable">
                                    Create New Contact
                                </button>
                                <div class="modal fade" id="exampleModalCenteredScrollable" tabindex="-1" aria-labelledby="additems" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="additems">Data No Handphone</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url(); ?>admin/contact/create" method="POST">
                                                <div class="modal-body">
                                                    <label for="noHp" class="form-label">No Handphone</label>
                                                    <input name="nohp" class="form-control form-control-lg" type="number" placeholder="Input Your Phone Number" aria-label=".form-control-lg example">

                                                    <label for="provider" class="form-label mt-3"><span class="text-danger">*</span> Provider</label>
                                                    <br>
                                                    <select name="provider" class="form-select" aria-label="Default select example">
                                                        <option selected>Select Provider</option>
                                                        <?php foreach($resultsProvider as $provider) : ?>
                                                            <option value="<?= $provider->provider_id ?>"><?= $provider->name_provider ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>           
                                                <div class="modal-footer">
                                                    <button type="submit" name="action" value="save" class="btn btn-secondary">Save</button>
                                                    <button type="submit" name="action" value="auto" class="btn btn-primary">Auto</button>
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
                                                    <th>Ganjil</th>
                                                    <th>Genap</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($resultsContact)) : ?>
                                            <?php foreach ($resultsContact as $num => $result) : ?>
                                                <tr>
                                                    <td><?= $num+1 ?></td>
                                                    <td><?= $result->ganjil_genep == "Ganjil" ? $result->phone : "" ?></td>
                                                    <td><?= $result->ganjil_genep == "Genap" ? $result->phone : "" ?></td>
                                                    <td>
                                                        
                                                        <button type="button" class="btn btn-primary m-b-sm" data-bs-toggle="modal" data-bs-target="#exampleModalCenteredScrollable<?= $result->contact_id ?>">
                                                            Edit
                                                        </button>
                                                        <div class="modal fade" id="exampleModalCenteredScrollable<?= $result->contact_id ?>" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                <<div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="additems">Data No Handphone</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="<?= base_url() . 'admin/contact/update/' . $result->contact_id ?>" method="POST">
                                                                        <div class="modal-body">
                                                                            <label for="noHp" class="form-label">No Handphone</label>
                                                                            <input value="<?= $result->phone ?>" name="nohp" class="form-control form-control-lg" type="number" placeholder="Input Your Phone Number" aria-label=".form-control-lg example">

                                                                            <label for="provider" class="form-label mt-3"><span class="text-danger">*</span> Provider</label>
                                                                            <br>
                                                                            <select name="provider" class="form-select" aria-label="Default select example">
                                                                                <?php foreach ($resultsProvider as $provider) : ?>
                                                                                    <option value="<?= $provider->provider_id ?>" <?php echo ($provider->provider_id == $result->provider->provider_id) ? 'selected' : ''; ?>>
                                                                                        <?= $provider->name_provider ?>
                                                                                    </option>
                                                                                <?php endforeach ?> 
                                                                            </select>
                                                                        </div>           
                                                                        <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-secondary">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" onclick="deleteContact('<?= $result->contact_id ?>')" class="btn btn-primary m-b-sm">
                                                            Delete
                                                        </button>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="12">Contact is empty</td>
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
<?= $this->include('Views/templates/jquery/contact') ?>

</body>

</html>