<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // SweetAlert will trigger automatically when the page is loaded
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: 'You do not have permission to access this page.',
            allowOutsideClick: false,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to base URL when "OK" is clicked
                window.location.href = '<?= base_url() ?>';
            }
        });
    </script>
</body>
</html>
