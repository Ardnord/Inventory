<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-cubes me-2"></i>
            Inventory App
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $aktif == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        Dashboard
                    </a>
                </li>
                
                <?php $master_aktif = in_array($aktif, ['barang', 'customer', 'supplier', 'petugas']); ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $master_aktif ? 'active' : '' ?>" href="#" id="masterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Master Data
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="masterDropdown">
                        <li><a class="dropdown-item <?= $aktif == 'barang' ? 'active' : '' ?>" href="<?= base_url('barang') ?>">Master Barang</a></li>
                        <li><a class="dropdown-item <?= $aktif == 'customer' ? 'active' : '' ?>" href="<?= base_url('customer') ?>">Master Customer</a></li>
                        <li><a class="dropdown-item <?= $aktif == 'supplier' ? 'active' : '' ?>" href="<?= base_url('supplier') ?>">Master Supplier</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item <?= $aktif == 'petugas' ? 'active' : '' ?>" href="<?= base_url('petugas') ?>">Master Petugas</a></li>
                    </ul>
                </li>

                <?php $transaksi_aktif = in_array($aktif, ['penerimaan', 'pengeluaran']); ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $transaksi_aktif ? 'active' : '' ?>" href="#" id="transaksiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Transaksi
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="transaksiDropdown">
                        <li><a class="dropdown-item <?= $aktif == 'penerimaan' ? 'active' : '' ?>" href="<?= base_url('penerimaan') ?>">Transaksi Penerimaan</a></li>
                        <li><a class="dropdown-item <?= $aktif == 'pengeluaran' ? 'active' : '' ?>" href="<?= base_url('pengeluaran') ?>">Transaksi Pengeluaran</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if ($this->session->login['role'] == 'admin'): ?>
                        <?php $pengaturan_aktif = in_array($aktif, ['pengguna', 'toko']); ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= $pengaturan_aktif ? 'active' : '' ?>" href="#" id="pengaturanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog me-1"></i> Pengaturan
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="pengaturanDropdown">
                                <li><a class="dropdown-item <?= $aktif == 'pengguna' ? 'active' : '' ?>" href="<?= base_url('pengguna') ?>">Manajemen Pengguna</a></li>
                                <li><a class="dropdown-item <?= $aktif == 'toko' ? 'active' : '' ?>" href="<?= base_url('toko') ?>">Profil Toko</a></li>
                            </ul>
                        </li>
                <?php endif; ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= $this->session->login['nama'] ?? 'Pengguna' ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profil
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout
                        </a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>