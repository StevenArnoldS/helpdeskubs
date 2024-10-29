<?php
global $rand_id;
$sql = 'SELECT * FROM M_USER';
$query = $this->db->query($sql);
if ($query->num_rows() > 0) {
    $result = $query->result_array();
}
$current_year = date('y');
$total_data = $query->num_rows() + 1;
$formatted_data = sprintf('%02d', $total_data);
$rand_id = 'U' . $current_year . '00' . $formatted_data;
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

    <link rel="stylesheet" href="<?php echo base_url('assets/css/user.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Master User</title>
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
                <h1 class="mt-4">Master User</h1>
                <div class="table-responsive mt-4">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="min-width: 200px; max-width: 200px;">ID</th>
                                <th style="min-width: 200px; max-width: 200px;">NIK</th>
                                <th style="min-width: 300px; max-width: 300px;">Username</th>
                                <th style="min-width: 200px; max-width: 200px;">Role</th>
                                <th style="min-width: 200px; max-width: 200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($query->num_rows() > 0) {
                                foreach ($result as $row) { ?>
                                    <tr>
                                        <td><?php echo $row["ID_USER"]; ?></td>
                                        <td><?php echo $row["NIK"]; ?></td>
                                        <td><?php echo $row["USERNAME"]; ?></td>
                                        <td id="role-<?php echo $row["ID_USER"]; ?>"><?php echo $row["ROLE"]; ?></td>
                                        <td>
                                            <!-- Kirimkan data ID_USER dan USERNAME ke modal -->
                                            <button class="btn btn-primary edit-role-btn" data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal" data-id="<?php echo $row['ID_USER']; ?>"
                                                data-username="<?php echo $row['USERNAME']; ?>"
                                                style="background-color: #487686 !important; border-color: #487686 !important;">
                                                Edit Role
                                            </button>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary edit-role-btn" data-bs-toggle="modal" data-bs-target="#addModal">Add
                    User</button>
                <!-- Modal Bootstrap -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="addModalLabel">Add User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addForm">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="addusername"
                                            aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password">
                                    </div>
                                    <input type="hidden" id="addId" value="<?php echo $rand_id; ?>">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Bootstrap -->
                <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white"
                                style="background-color: #487686 !important;">
                                <h5 class="modal-title" id="editRoleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editRoleForm">
                                    <div class="mb-3">
                                        <label for="roleSelect" class="form-label">Pilih Role:</label>
                                        <select class="form-select" id="roleSelect">
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                            <option value="Guest">Guest</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="userId" value="">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveRoleBtn"
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
                scrollY: "500px",
                scrollCollapse: true,  // Aktifkan scroll vertikal hanya jika tinggi tabel melebihi 500px
                dom: '<"d-flex justify-content-between" lBf>rt<"d-flex justify-content-between"ip>',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [10, 25, 50, 100]
            });
        });

        $('.edit-role-btn').on('click', function () {
            // Ambil ID dan Username dari tombol yang di klik
            var userId = $(this).data('id');
            var username = $(this).data('username');
            var textHeader = "Edit Role " + username;

            // Isi hidden input dengan ID User yang dipilih
            $('#userId').val(userId);
            $('#editRoleModalLabel').text(textHeader);
        });

        $('#saveRoleBtn').on('click', function () {
            // Ambil data dari modal
            var userId = $('#userId').val();
            var role = $('#roleSelect').val();

            // Kirim data dengan AJAX ke controller untuk diupdate
            $.ajax({
                url: '<?= base_url('index.php/UserController/updateRole') ?>', // URL ke controller
                type: 'POST',
                data: {
                    userId: userId,
                    role: role
                },
                dataType: 'json', // Format data yang diterima kembali dari server
                success: function (response) {
                    if (response.status == 'success') {
                        // Jika berhasil, update kolom role di tabel tanpa refresh halaman
                        $('#role-' + userId).text(role);
                        $('#editRoleModal').modal('hide');
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Error updating role');
                }
            });
        });
        $('#save').on('click', function () {
            // Ambil data dari modal
            var addId = $('#addId').val();
            var nik = $('#nik').val();
            var username = $('#addusername').val();
            var password = $('#password').val();

            // Validasi sederhana di sisi client
            if (addId === '' || nik === '' || username === '' || password === '') {
                alert('All fields are required');
                return; // Berhenti jika validasi gagal
            }

            // Kirim data dengan AJAX ke controller untuk diupdate
            $.ajax({
                url: '<?= base_url('index.php/UserController/addUser') ?>', // Pastikan URL benar
                type: 'POST',
                data: {
                    addId: addId,
                    nik: nik,
                    username: username,
                    password: password // Kirim password sebagai plain text untuk dienkripsi di server
                },
                dataType: 'json', // Format data yang diterima kembali dari server
                success: function (response) {
                    if (response.status === 'success') {
                        // Jika sukses
                        $('#addModal').modal('hide'); // Tutup modal
                        alert(response.message); // Pesan sukses
                        location.reload(); // Reload halaman
                    } else {
                        // Jika gagal, tampilkan pesan error
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Tangani error jika request gagal
                    console.error('AJAX Error: ', error);
                    alert('An error occurred while adding user');
                }
            });
        });

    </script>

</body>

</html>