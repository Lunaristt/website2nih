<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color:#8b0d18;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="<?php echo e(route('home')); ?>">☰ Toko Sumber Rejeki</a>

        <div class="dropdown ms-auto">
            <button class="btn btn-outline-light dropdown-toggle fw-bold" type="button" id="userMenu"
                data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo e($authUser->Nama ?? 'Pengguna'); ?> 👤
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <?php if(isset($authUser) && $authUser->Role === 'admin'): ?>
                    <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                <?php endif; ?>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item text-danger fw-semibold">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav><?php /**PATH F:\Proyek\Kuliah\Website\skripsi\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>