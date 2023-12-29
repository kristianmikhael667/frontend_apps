<!-- Header -->
<?= $this->include('Views/templates/admin/auth/head') ?>

    <div class="app horizontal-menu app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="#">Jelajah Teknologi Negeri</a>
            </div>
            <p></p>

                <div class="auth-credentials m-b-xxl">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control m-b-md" id="email" aria-describedby="email" placeholder="Email">

                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" aria-describedby="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                </div>

                <div class="auth-submit">
                    <button type="button" onclick="login()" class="btn btn-primary">Sign In</button>

                </div>
        </div>
    </div>
<!-- Jquery -->
<?= $this->include('Views/templates/admin/auth/script') ?>

<!-- Logic -->
<?= $this->include('Views/templates/admin/auth/ajax') ?>
