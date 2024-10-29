<?php
$nik = $this->session->userdata('user_id');
if ($nik) {
    // Get the ID_USER based on NIK from M_USER table
    $this->db->select('ID_USER');
    $this->db->from('M_USER');
    $this->db->where('NIK', $nik);
    $user_query = $this->db->get();
    $user_result = $user_query->row_array();

    if (!empty($user_result)) {
        $id_user = $user_result['ID_USER'];

        // Fetch tickets for this user
        $this->db->select("ID_TICKET, PROBLEM, PHONE, TECHNICIAN, STATUS, CATEGORY, NOTE, 
                   TO_CHAR(TICKET_DATE, 'DD Mon YYYY HH24:MI') AS TICKET_DATE, 
                   TO_CHAR(COMPLETED_DATE, 'DD Mon YYYY HH24:MI') AS COMPLETED_DATE");
        $this->db->from('M_TICKET');
        $this->db->where('TECHNICIAN', $id_user); // Filter by ID_USER
        $this->db->where('STATUS', 'Finished');
        $query = $this->db->get();
        $result = $query->result_array();

        // Fetch categories for the dropdown
        $category_query = $this->db->get('M_CATEGORY');
        $categories = $category_query->result_array();
    }
}
?>
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
    <title>Finished Ticket</title>
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
                <h1 class="mt-4">Finished Ticket</h1>
                <div class="table-responsive mt-4">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="min-width: 125px; max-width: 125px;">No Ticket</th>
                                <th style="min-width: 500px; max-width: 500px;">Problem</th>
                                <th style="min-width: 200px; max-width: 200px;">Phone Number</th>
                                <th style="min-width: 250px; max-width: 250px;">Ticket Date</th>
                                <th style="min-width: 200px; max-width: 200px;">Technician</th>
                                <th style="min-width: 150px; max-width: 150px;">Ticket Status</th>
                                <th style="min-width: 200px; max-width: 200px;">Category</th>
                                <th style="min-width: 250px; max-width: 250px;">Completion Date</th>
                                <th style="min-width: 500px; max-width: 500px;">Note</th>
                                <th style="min-width: 150px; max-width: 125px;">Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($query->num_rows() > 0) {
                                foreach ($result as $row) { ?>
                                    <tr>
                                        <td><?php echo $row["ID_TICKET"]; ?></td>
                                        <td><?php echo $row["PROBLEM"]; ?></td>
                                        <td><?php echo $row["PHONE"]; ?></td>
                                        <!-- Display the formatted date and time directly from the query -->
                                        <td><?php echo $row["TICKET_DATE"]; ?></td>
                                        <td><?php echo $row["TECHNICIAN"]; ?></td>
                                        <td><?php echo $row["STATUS"]; ?></td>
                                        <td><?php echo $row["CATEGORY"]; ?></td>
                                        <td><?php echo $row["COMPLETED_DATE"]; ?></td>
                                        <td><?php echo $row["NOTE"]; ?></td>
                                        <td>
                                            <div class="icon-wrapper">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                scrollX: true,  // Mengaktifkan scroll horizontal
                scrollY: "500px",
                scrollCollapse: true,  // Aktifkan scroll vertikal hanya jika tinggi tabel melebihi 500px
                dom: '<"d-flex justify-content-between" lBf>rt<"d-flex justify-content-between"ip>',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [10, 25, 50, 100]
            });
        });

    </script>

</body>

</html>