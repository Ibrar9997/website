<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Vector map-->
<script src="assets/libs/jsvectormap/jsvectormap.min.js"></script>
<script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

<!-- Dashboard init -->
<script src="assets/js/pages/dashboard-analytics.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

<script>
    $('#profileForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Saving...',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: Object.values(errors)[0][0],
                        showConfirmButton: false,
                        timer: 3500
                    });
                }
            }
        });
    });
    </script>

