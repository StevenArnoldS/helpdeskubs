<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/index.css'); ?>">
    <script src="<?php echo base_url('assets/js/index.js'); ?>"></script>

    <title>Helpdesk</title>
</head>

<body>
    <div class="wrapper">
        <nav class="montserrat-semiBold" id="sidebar">
            <img src="<?php echo base_url() ?>assets/images/logo.png">

            <ul class="list-unstyled components" id="listNav">
                <li>
                    <a href="<?= base_url() ?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/welcome/allticket"><i class="fa-solid fa-ticket" style="color: #ffffff;"></i></i>All Ticket</a>
                </li>
                <li>
                    <a href="#homeSubmenu" class="nav-link dropdown-toggle p-0" data-bs-toggle="collapse"
                        aria-expanded="false" id="myticket"><i class="fa-solid fa-ticket" style="color: #ffffff;"></i></i>My Ticket</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="<?= base_url() ?>index.php/welcome/finished">Finished</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>index.php/welcome/unfinished">Unfinished</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/welcome/category"><i class="fa-solid fa-list" style="color: #ffffff;"></i></i>Master Category</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/welcome/schedule"><i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i></i>Master Schedule</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/welcome/user"><i class="fa-regular fa-user" style="color: #ffffff;"></i></i>Master User</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/UserController/logout" style="color: red !important;"><i class="fa-solid fa-right-from-bracket" style="color: #ff0000;"></i>Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div class="ms-5" id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-bars"></i>
            </button>
            <div class="container">
                <h1 class="mt-4">Dashboard</h1>
                <div class="container-fluid d-flex mt-4" id="head-container">
                    <div class="container-fluid d-flex" id="container-ticket">
                        <div class="container" id="ticket" style="background: #487686">
                            <img src="<?php echo base_url() ?>assets/images/ticket.png" alt="ticket">
                        </div>
                        <div class="container" id="isi">
                            <h3>10</h3>
                            <p>Total Ticket</p>
                        </div>
                    </div>
                    <div class="container-fluid d-flex" id="container-ticket">
                        <div class="container" id="ticket" style="background: #7EB26D">
                            <img src="<?php echo base_url() ?>assets/images/ticket.png" alt="ticket">
                        </div>
                        <div class="container" id="isi">
                            <h3>10</h3>
                            <p>Finished Ticket</p>
                        </div>
                    </div>
                    <div class="container-fluid d-flex" id="container-ticket">
                        <div class="container" id="ticket" style="background: #E42D24">
                            <img src="<?php echo base_url() ?>assets/images/ticket.png" alt="ticket">
                        </div>
                        <div class="container" id="isi">
                            <h3>10</h3>
                            <p>Unfinished Ticket</p>
                        </div>
                    </div>
                </div>
                <div class="container-fluid d-flex chart-container mt-4">
                    <div class="chart">
                        <h2>Status</h2>
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="chart">
                        <h2>Category</h2>
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Finished', 'On Progress', 'Waiting'],
                datasets: [{
                    data: [7, 2, 1],
                    backgroundColor: [
                        'rgb(126,178,109)',
                        'rgb(228,45,36)',
                        'rgb(234,184,57)'
                    ],
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('myChart2');

        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Human Error', 'Network', 'Hardware'],
                datasets: [{
                    data: [4, 2, 1],
                    backgroundColor: [
                        'rgb(230,217,162)',
                        'rgb(203,128,171)',
                        'rgb(137,103,179)'
                    ],
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>

</body>

</html>