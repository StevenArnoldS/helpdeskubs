<?php
global $rand_id;
$sql = 'SELECT * FROM M_CATEGORY';
$query = $this->db->query($sql);
if ($query->num_rows() > 0) {
    $result = $query->result_array();
}
$current_year = date('y');
$total_data = $query->num_rows() + 1;
$formatted_data = sprintf('%02d', $total_data);
$rand_id = 'C' . $current_year . '00' . $formatted_data;
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
    <link rel="stylesheet" href="<?php echo base_url('assets/css/category.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Master Category</title>
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
                <h1 class="mt-4">Master Category</h1>
                <div class="table-responsive mt-4">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="min-width: 200px; max-width: 200px;">ID</th>
                                <th style="min-width: 600px; max-width: 600px;">Category</th>
                                <th style="min-width: 300px; max-width: 300px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($query->num_rows() > 0) {
                                foreach ($result as $row) { ?>
                                    <tr>
                                        <td><?php echo $row["ID"]; ?></td>
                                        <td><?php echo $row["CATEGORY"]; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-link p-0 edit-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" data-id="<?php echo $row["ID"]; ?>"
                                                    data-category="<?php echo $row["CATEGORY"]; ?>">
                                                    <i class="fa-solid fa-pen" style="color: #487686;"></i>
                                                </button>
                                                <button class="btn btn-link p-0" id="delete">
                                                    <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary edit-role-btn" data-bs-toggle="modal" data-bs-target="#addModal">Add
                    Category</button>
                <!-- Modal Bootstrap -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addForm">
                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Category Name:</label>
                                        <div>
                                            <input type="text" id="categoryName" class="form-control w-100"
                                                placeholder="Enter category name">
                                        </div>
                                    </div>
                                    <input type="hidden" id="categoryId" value="<?php echo $rand_id; ?>">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Editing -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm">
                                    <div class="mb-3">
                                        <label for="editCategoryName" class="form-label">Category Name:</label>
                                        <div>
                                            <input type="text" id="editCategoryName" class="form-control w-100">
                                        </div>
                                    </div>
                                    <input type="hidden" id="editCategoryId">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="edit">Save changes</button>
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
                scrollY: "400px",
                scrollCollapse: true,  // Aktifkan scroll vertikal hanya jika tinggi tabel melebihi 500px
                dom: '<"d-flex justify-content-between" lBf>rt<"d-flex justify-content-between"ip>',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                lengthMenu: [10, 25, 50, 100]
            });

            $('#save').on('click', function () {
                // Ambil data dari modal
                var categoryId = $('#categoryId').val();
                var categoryName = $('#categoryName').val();

                // Kirim data dengan AJAX ke controller untuk diupdate
                $.ajax({
                    url: '<?= base_url('index.php/UserController/add') ?>', // URL ke controller
                    type: 'POST',
                    data: {
                        categoryId: categoryId,
                        categoryName: categoryName
                    },
                    dataType: 'json', // Format data yang diterima kembali dari server
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#addModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Error updating role');
                    }
                });
            });

            $(document).on('click', '#delete', function () {
                // Ambil ID kategori dari baris yang dipilih
                var categoryId = $(this).closest('tr').find('td:first').text();

                // Tampilkan konfirmasi sebelum menghapus
                if (confirm('Are you sure you want to delete this category?')) {
                    // Kirim data dengan AJAX ke controller untuk dihapus
                    $.ajax({
                        url: '<?= base_url('index.php/UserController/delete') ?>', // URL ke controller delete
                        type: 'POST',
                        data: {
                            categoryId: categoryId
                        },
                        dataType: 'json', // Format data yang diterima kembali dari server
                        success: function (response) {
                            if (response.status == 'success') {
                                alert('Category deleted successfully');
                                location.reload(); // Reload halaman setelah delete berhasil
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function () {
                            alert('Error deleting category');
                        }
                    });
                }
            });

            $('.edit-btn').on('click', function () {
                // Ambil ID dan nama kategori dari atribut data
                var categoryId = $(this).data('id');
                var categoryName = $(this).data('category');

                // Isi input modal dengan data kategori
                $('#editCategoryId').val(categoryId);
                $('#editCategoryName').val(categoryName);
            });

            $('#edit').on('click', function () {
                // Ambil data dari modal
                var categoryId = $('#editCategoryId').val();
                var categoryName = $('#editCategoryName').val();
                console.log('categoryId:', categoryId);
                console.log('categoryName:', categoryName);

                // Kirim data dengan AJAX ke controller untuk diupdate
                $.ajax({
                    url: '<?= base_url('index.php/UserController/edit') ?>', // URL ke controller
                    type: 'POST',
                    data: {
                        categoryId: categoryId,
                        categoryName: categoryName
                    },
                    dataType: 'json', // Format data yang diterima kembali dari server
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#editModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Error updating role');
                    }
                });
            });
        });
    </script>

</body>

</html>