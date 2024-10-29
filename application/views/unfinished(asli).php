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
        $this->db->select("ID_TICKET, PROBLEM, PHONE, TO_CHAR(TICKET_DATE, 'DD Mon YYYY HH24:MI') AS TICKET_DATE, CATEGORY");
        $this->db->from('M_TICKET');
        $this->db->where('TECHNICIAN', $id_user); // Filter by ID_USER
        $this->db->where('STATUS', 'unfinished');
        $query = $this->db->get();
        $result = $query->result_array();

        // Fetch categories for the dropdown
        $category_query = $this->db->get('M_CATEGORY');
        $categories = $category_query->result_array();
    }
}
$category_query = $this->db->query("SELECT * FROM M_CATEGORY");
$categories = $category_query->result_array();
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
    <link rel="stylesheet" href="<?php echo base_url('assets/css/unfinished.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Unfinished Ticket</title>
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
                <h1 class="mt-4">Unfinished Ticket</h1>
                <div class="table-responsive mt-4">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="min-width: 125px; max-width: 125px;">No Ticket</th>
                                <th style="min-width: 500px; max-width: 500px;">Problem</th>
                                <th style="min-width: 200px; max-width: 200px;">Phone Number</th>
                                <th style="min-width: 250px; max-width: 250px;">Ticket Date</th>
                                <th style="min-width: 200px; max-width: 200px;">Category</th>
                                <th style="min-width: 500px; max-width: 500px;">Action</th>
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
                                        <td>
                                            <select class="form-select">
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category['ID']; ?>" <?php if ($row["CATEGORY"] == $category['ID'])
                                                           echo 'selected'; ?>>
                                                        <?php echo $category['CATEGORY']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="container d-flex" style="gap: 1rem;">
                                                <div class="icon-wrapper">
                                                    <button data-bs-toggle="modal" data-bs-target="#note" class="note-btn"
                                                        data-ticket-id="<?php echo $row["ID_TICKET"]; ?>"><i
                                                            class="fa-regular fa-note-sticky"></i></button>
                                                </div>
                                                <div class="icon-wrapper">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                                        <i class="fa-solid fa-paperclip"></i>
                                                    </button>
                                                </div>
                                                <button><i class="fa-solid fa-circle-check" id="btn-check"
                                                        style="color: #00ff00; font-size: 30px;"></i></button>
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

        <div class="modal fade" id="note" tabindex="-1" aria-labelledby="noteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="noteLabel">Add Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="noteForm">
                            <div class="mb-12">
                                <div>
                                    <textarea class="form-control" id="textNote" placeholder="Enter note here"
                                        style="height: 15rem; resize: none;"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Attachment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="uploadForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Choose a file</label>
                                <input class="form-control" type="file" id="attachment" name="attachment" accept="*">
                            </div>
                            <input type="hidden" id="ticket_id" name="ticket_id"
                                value="<?php echo $row['ID_TICKET']; ?>">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="uploadButton">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var ticketId = null;
            var table = $('#example').DataTable({
                scrollX: true,  // Mengaktifkan scroll horizontal
                scrollY: "500px",
                scrollCollapse: true,  // Aktifkan scroll vertikal hanya jika tinggi tabel melebihi 500px
                dom: '<"d-flex justify-content-between" lBf>rt<"d-flex justify-content-between"ip>',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [10, 25, 50, 100]
            });

            $('#uploadButton').click(function () {
                var formData = new FormData($('#uploadForm')[0]);

                $.ajax({
                    url: '<?php echo base_url("index.php/UserController/upload_attachment"); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Parse the response if needed (sometimes it's already parsed)
                        var res = JSON.parse(response);

                        if (res.success) {
                            alert(res.message); // Display the success message
                            $('#uploadModal').modal('hide');
                        } else {
                            alert(res.message); // Display the error message from the server
                        }
                    },
                    error: function () {
                        alert('An error occurred while uploading the file.');
                    }
                });
            });

            $('.note-btn').on('click', function () {
                ticketId = $(this).data('ticket-id'); // Ambil ID_TICKET dari tombol yang diklik

                // Lakukan AJAX untuk mendapatkan note yang ada
                $.ajax({
                    url: '<?php echo base_url("index.php/UserController/get_note"); ?>',
                    type: 'POST',
                    data: { ticket_id: ticketId },
                    success: function (response) {
                        var res = JSON.parse(response);

                        if (res.success) {
                            $('#textNote').val(res.note); // Tampilkan note dari database di textarea
                        } else {
                            $('#textNote').val(''); // Kosongkan textarea jika tidak ada note
                        }
                    },
                    error: function () {
                        alert('An error occurred while fetching the note.');
                    }
                });
            });

            // Ketika tombol save diklik, simpan atau update note ke database
            $('#save').on('click', function () {
                var note = $('#textNote').val();

                // Lakukan AJAX untuk menyimpan note
                $.ajax({
                    url: '<?php echo base_url("index.php/UserController/save_note"); ?>',
                    type: 'POST',
                    data: {
                        ticket_id: ticketId,
                        note: note
                    },
                    success: function (response) {
                        var res = JSON.parse(response);

                        if (res.success) {
                            alert(res.message); // Tampilkan pesan sukses
                            $('#note').modal('hide'); // Tutup modal setelah sukses menyimpan
                        } else {
                            alert(res.message); // Tampilkan pesan error dari server
                        }
                    },
                    error: function () {
                        alert('An error occurred while saving the note.');
                    }
                });
            });

            $('#btn-check').on('click', function () {
                var ticketId = $(this).closest('tr').find('.note-btn').data('ticket-id'); // Mendapatkan ID_TICKET
                var categoryId = $(this).closest('tr').find('.form-select').val(); // Mendapatkan value kategori dari select box

                $.ajax({
                    url: '<?= base_url('index.php/UserController/update_status') ?>', // Endpoint controller
                    type: 'POST',
                    data: {
                        ticket_id: ticketId,
                        category_id: categoryId
                    },
                    success: function (response) {
                        alert('Ticket updated successfully');
                        location.reload(); // Untuk merefresh halaman jika diperlukan
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

        });

    </script>

</body>

</html>