<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"/>
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/inventory.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>
    <body class="hold-transition sidebar-mini dark-mode">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-black navbar-dark">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> <i class="fas fa-user-circle"></i> Admin </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#"> <i class="fas fa-user me-2"></i> Profile </a>
                            </li>
                            <li><hr class="dropdown-divider"> </li>
                            <li> <a class="dropdown-item" href="#"> <i class="fas fa-sign-out-alt me-2"></i> Logout </a> </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="brand-link">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Tile Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text fw-light">Tile</span>
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                        </ul>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link"><i class="nav-icon fas fa-gauge-high"></i><p>Dashboard</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('inventory_list') }}" class="nav-link"><i class="nav-icon fas fa-boxes-stacked"></i><p>Inventory List</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('master_list') }}" class="nav-link"><i class="nav-icon fas fa-boxes-stacked"></i><p>Master List</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reports') }}" class="nav-link"><i class="nav-icon fas fa-boxes-stacked"></i><p>Reports</p></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dealer_details') }}" class="nav-link"><i class="nav-icon fas fa-boxes-stacked"></i><p>Dealer Details</p></a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>