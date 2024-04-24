@if (session('success'))
<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            type: 'success',
            title: '{{ session("success")}}'
        });
    })
</script>
@endif

@if (session('error'))

<script>
    new Noty({
        type: 'error',
        layout: 'topRight',
        text: "{{ session('error') }}",
        timeout: 2000,
        killer: true
    }).show();
</script>

@endif