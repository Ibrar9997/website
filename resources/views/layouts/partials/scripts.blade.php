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
    Toast.fire({
        icon: 'success',
        title: response.message
    });
},
error: function (xhr) {
    if (xhr.status === 422) {
        Toast.fire({
            icon: 'error',
            title: Object.values(xhr.responseJSON.errors)[0][0]
        });
    }
}

        });
    });
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @endif

    @if(session('status'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('status') }}"
        });
    @endif

    @if($errors->any())
        Toast.fire({
            icon: 'error',
            title: "{{ $errors->first() }}"
        });
    @endif
</script>

<script>
    $(document).ready(function () {

        $('#categoryForm').on('submit', function (e) {
            e.preventDefault();

            let form = this;

            // Bootstrap frontend validation
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            $.ajax({
                url: $(form).attr('action'),
                type: "POST",
                data: $(form).serialize(),

                beforeSend: function () {
                    Toast.fire({
                        icon: 'info',
                        title: 'Saving category...'
                    });
                },

                success: function (response) {

                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });

                    // Reset form + validation
                    form.reset();
                    form.classList.remove('was-validated');

                    // Close modal
                    $('#showModal').modal('hide');

                    // OPTIONAL: reload or append row
                    // location.reload();
                },

                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let firstError = Object.values(errors)[0][0];

                        Toast.fire({
                            icon: 'error',
                            title: firstError
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                    }
                }
            });
        });

    });
    </script>

