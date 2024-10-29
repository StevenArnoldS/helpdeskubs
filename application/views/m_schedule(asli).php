<?php
global $rand_id;
$sqlUser = 'SELECT * FROM M_USER';
$queryUser = $this->db->query($sqlUser);
if ($queryUser->num_rows() > 0) {
    $resultUser = $queryUser->result_array();
}
$sqlSchedule = 'SELECT * FROM M_SCHEDULE JOIN M_USER ON M_SCHEDULE.ID_USER = M_USER.ID_USER';
$querySchedule = $this->db->query($sqlSchedule);
if ($querySchedule->num_rows() > 0) {
    $resultSchedule = $querySchedule->result_array();
}
$current_year = date('y');
$total_data = $querySchedule->num_rows() + 1;
$formatted_data = sprintf('%02d', $total_data);
$rand_id = 'S' . $current_year . '00' . $formatted_data;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" rel="stylesheet">

    <!-- Link CSS Buttons DataTables -->
    <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Script DataTables -->
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>

    <!-- Script DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>

    <!-- Script untuk mendukung export (Excel, PDF, Print) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/finished.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- Daterangepicker JS & CSS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="<?php echo base_url('assets/css/schedule.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Datepicker JS -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <title>Master Schedule</title>
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
                    <a href="<?= base_url() ?>index.php/welcome/allticket"><i class="fa-solid fa-ticket"
                            style="color: #ffffff;"></i></i>All Ticket</a>
                </li>
                <li>
                    <a href="#homeSubmenu" class="nav-link dropdown-toggle p-0" data-bs-toggle="collapse"
                        aria-expanded="false" id="myticket"><i class="fa-solid fa-ticket"
                            style="color: #ffffff;"></i></i>My Ticket</a>
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
                    <a href="<?= base_url() ?>index.php/welcome/category"><i class="fa-solid fa-list"
                            style="color: #ffffff;"></i></i>Master Category</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/welcome/schedule"><i class="fa-solid fa-calendar-days"
                            style="color: #ffffff;"></i></i>Master Schedule</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/welcome/user"><i class="fa-regular fa-user"
                            style="color: #ffffff;"></i></i>Master User</a>
                </li>
                <li>
                    <a href="<?= base_url() ?>index.php/UserController/logout" style="color: red !important;"><i
                            class="fa-solid fa-right-from-bracket" style="color: #ff0000;"></i>Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div class="ms-5" id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-bars"></i>
            </button>
            <div class="container">
                <h1 class="mt-4">Master Schedule</h1>
                <div class="container my-4">
                    <div class="d-flex align-items-center">
                        <!-- Bagian Tulisan Select Date -->
                        <p class="me-3 mb-0">Select Date Range:</>
                            <!-- Bagian Select Date Range -->
                        <div class="input-group" style="max-width: 250px;">
                            <input type="text" class="form-control" id="date-range" placeholder="Select Date Range">
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="min-width: 350px; max-width: 350px;">Id Schedule</th>
                                <th style="min-width: 350px; max-width: 350px;">Date</th>
                                <th style="min-width: 400px; max-width: 400px;">Technician Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($querySchedule->num_rows() > 0) {
                                foreach ($resultSchedule as $row) { ?>
                                    <tr>
                                        <td><?php echo $row["ID_SCHEDULE"]; ?></td>
                                        <td><?php echo $row["SCHEDULE_DATE"]; ?></td>
                                        <td><?php echo $row["USERNAME"]; ?></td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary edit-role-btn mt-2" data-bs-toggle="modal"
                    data-bs-target="#modalSchedule">Add
                    Schedule</button>

                <div class="modal fade" id="modalSchedule" tabindex="-1" aria-labelledby="editRoleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white"
                                style="background-color: #487686 !important;">
                                <h5 class="modal-title" id="editRoleModalLabel">Add Schedule</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="categoryForm">
                                    <div class="mb-3">
                                        <label for="roleSelect" class="form-label">Select User:</label>
                                        <select class="form-select" name="user" id="userId">
                                            <?php if ($queryUser->num_rows() > 0) {
                                                foreach ($queryUser->result() as $row) { ?>
                                                    <option value="<?php echo $row->ID_USER; ?>"><?php echo $row->USERNAME; ?>
                                                    </option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="scheduleDate" class="form-label">Select Date:</label>
                                        <input type="text" class="form-control" id="scheduleDate" name="schedule_date"
                                            placeholder="Select Date">
                                    </div>

                                    <input type="hidden" id="scheduleId" value="<?php echo $rand_id; ?>">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save"
                                    style="background-color: #487686 !important; border-color: #487686 !important;">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                scrollX: true,  // Mengaktifkan scroll horizontal
                scrollY: "350px",
                scrollCollapse: true,  // Aktifkan scroll vertikal hanya jika tinggi tabel melebihi 500px
                dom: '<"d-flex justify-content-between" lBf>rt<"d-flex justify-content-between"ip>',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [10, 25, 50, 100]
            });

            $('#date-range').daterangepicker({
                opens: 'left',
                drops: 'down',
                autoApply: true,
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' - ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 0
                }
            }, function (start, end, label) {
                $('#date-range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $.ajax({
                    url: '<?php echo base_url("index.php/UserController/get_filtered_schedule"); ?>',
                    method: 'POST',
                    data: {
                        startDate: start.format('YYYY-MM-DD'),
                        endDate: end.format('YYYY-MM-DD')
                    },
                    dataType: 'json',  // Expecting JSON response
                    success: function (response) {
                        // Clear the table
                        table.clear().draw();

                        // Check if there are records
                        if (response.length > 0) {
                            // Loop through each schedule and append it to the DataTable
                            response.forEach(function (row) {
                                table.row.add([
                                    row.ID_SCHEDULE,
                                    row.SCHEDULE_DATE,
                                    row.USERNAME
                                ]).draw();
                            });
                        } else {
                            table.row.add(['No records found', '', '']).draw();
                        }
                    },
                    error: function () {
                        alert('Error retrieving schedules');
                    }
                });

            });

            // Adjust calendar width to match input width
            $('#date-range').on('show.daterangepicker', function (ev, picker) {
                picker.container.css({
                    width: $(this).outerWidth() + 'px'
                });
            });

            $('#scheduleDate').datepicker({
                format: 'yyyy-mm-dd',      // Format tanggal
                autoclose: true,           // Menutup otomatis setelah memilih tanggal
                todayHighlight: true,
                orientation: "bottom",      // Menyoroti hari ini
                container: '#modalSchedule',  // Agar positioning datepicker tidak bermasalah di dalam modal
            });

            $('#save').on('click', function () {
                // Ambil data dari form
                var userId = $('#userId').val();
                var scheduleDate = $('#scheduleDate').val();
                var scheduleId = $('#scheduleId').val();
                // alert(scheduleDate);

                // Kirim data dengan AJAX ke controller untuk ditambahkan
                $.ajax({
                    url: '<?= base_url('index.php/UserController/addCategory') ?>', // URL ke controller
                    type: 'POST',
                    data: {
                        userId: userId,
                        scheduleDate: scheduleDate,
                        scheduleId: scheduleId
                    },
                    dataType: 'json', // Format data yang diterima kembali dari server
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#addModal').modal('hide');
                            alert('Sukses');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Error adding schedule');
                    }
                });
            });

        });

    </script>

</body>

</html>