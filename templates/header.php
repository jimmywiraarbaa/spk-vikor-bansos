<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK VIKOR BANSOS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css'); ?>">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
        }

        /* Sidebar Styles */
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #ffffff;
            color: #333;
            transition: all 0.3s cubic-bezier(0.945, 0.020, 0.270, 0.665);
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.02);
            z-index: 1000;
            min-height: 100vh;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #ffffff;
            border-bottom: 1px solid #f1f1f1;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }
#sidebar ul li a {
    padding: 12px 25px;
    font-size: 0.95rem;
    display: block;
    color: #555;
    text-decoration: none !important;
    transition: 0.2s;
    font-weight: 500;
    border-left: 4px solid transparent;
    outline: none;
}

/* Hide Bootstrap default caret */
.dropdown-toggle::after {
    display: none !important;
}

/* Submenu Styles */
        #sidebar ul li a:hover {
            color: #d9534f;
            background: #fff5f5;
            border-left: 4px solid #d9534f;
        }

        #sidebar ul li.active>a {
            color: #d9534f;
            background: #fff5f5;
            border-left: 4px solid #d9534f;
        }

        #sidebar ul li a i:first-child {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .arrow-icon {
            font-size: 0.8rem;
            color: #adb5bd;
            transition: transform 0.3s ease;
        }

        #sidebar ul li a[aria-expanded="true"] .arrow-icon {
            transform: rotate(180deg);
            color: #d9534f;
        }

        .user-arrow-icon {
            font-size: 0.7rem;
            color: #adb5bd;
            transition: transform 0.3s ease;
            margin-left: 8px;
        }

        .dropdown-toggle[aria-expanded="true"] .user-arrow-icon {
            transform: rotate(180deg);
        }

        /* Page Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 20px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translate3d(-30px, 0, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translate3d(30px, 0, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        .animate-up { animation: fadeInUp 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) both; }
        .animate-left { animation: fadeInLeft 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) both; }
        .animate-right { animation: fadeInRight 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) both; }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Hide Bootstrap default caret */
        #sidebar ul ul li a {
            padding: 10px 25px 10px 55px !important;
            font-size: 0.85rem !important;
            background: #fbfbfb;
        }

        #sidebar .menu-label {
            padding: 20px 25px 10px 25px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #adb5bd;
            letter-spacing: 1px;
        }

        /* Content Styles */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s;
            background-color: #f4f7f6;
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        .top-navbar {
            padding: 10px 20px;
            background: #fff;
            border-bottom: 1px solid #f1f1f1;
            position: sticky;
            top: 0;
            z-index: 997;
        }

        .main-content {
            padding: 25px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
                position: fixed;
                height: 100%;
            }

            #sidebar.active {
                margin-left: 0;
            }

            .main-content {
                padding: 15px;
            }

            .top-navbar {
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="overlay"></div>