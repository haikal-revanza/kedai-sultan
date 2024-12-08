<nav class="h-100 bg-light">
    <ul class="nav flex-column p-3">
        <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link text-dark {{ Request::is('admin/dashboard') ? 'bg-primary text-white' : '' }}">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/menus" class="nav-link text-dark {{ Request::is('admin/menus*') ? 'bg-primary text-white' : '' }}">
                CRUD Menu
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/reports" class="nav-link text-dark {{ Request::is('admin/reports*') ? 'bg-primary text-white' : '' }}">
                Laporan
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/users" class="nav-link text-dark {{ Request::is('admin/users*') ? 'bg-primary text-white' : '' }}">
                Tambah User
            </a>
        </li>
    </ul>
</nav>
