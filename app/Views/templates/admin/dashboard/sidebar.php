<div class="app-menu">
    <div class="container">
        <!-- Link -->
        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
      
        <ul class="menu-list">
            <li class="<?= $current_page == 'dashboard' ? 'active-page' : '' ?>">
                <a href="<?= base_url('admin/dashboard') ?>" class="<?= $current_page == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
            </li>
            <li class="<?= $current_page == 'provider' ? 'active-page' : '' ?>">
                <a href="<?= base_url('admin/provider') ?>" class="<?= $current_page == 'provider' ? 'active' : '' ?>">Provider</a>
            </li>
            <li class="<?= $current_page == 'contact' ? 'active-page' : '' ?>">
                <a href="<?= base_url('admin/contact') ?>" class="<?= $current_page == 'contact' ? 'active' : '' ?>">Contact</a>
            </li>

        </ul>
    </div>
</div>