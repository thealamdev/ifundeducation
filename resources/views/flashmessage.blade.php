@if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{ Session::get('success') }}",
            showConfirmButton: false,
            timer: 30000,
            timerProgressBar: true,
            padding: '1em',
            customClass: {
                'title': 'alert_title',
                'icon': 'alert_icon',
                'timerProgressBar': 'bg-success',
            }
        })
    </script>
@endif


@if (Session::has('error'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "{{ Session::get('error') }}",
            showConfirmButton: false,
            timer: 30000,
            timerProgressBar: true,
            padding: '1em',
            customClass: {
                'title': 'alert_title',
                'icon': 'alert_icon',
                'timerProgressBar': 'bg-danger',
            }
        })
    </script>
@endif

@if (Session::has('info'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: "{{ Session::get('info') }}",
            showConfirmButton: false,
            timer: 30000,
            timerProgressBar: true,
            padding: '1em',
            customClass: {
                'title': 'alert_title',
                'icon': 'alert_icon',
                'timerProgressBar': 'bg-info',
            }
        })
    </script>
@endif

@if (Session::has('warning'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'danger',
            title: "{{ Session::get('warning') }}",
            showConfirmButton: false,
            timer: 30000,
            timerProgressBar: true,
            padding: '1em',
            customClass: {
                'title': 'alert_title',
                'icon': 'alert_icon',
                'timerProgressBar': 'bg-warning',
            }
        })
    </script>
@endif
