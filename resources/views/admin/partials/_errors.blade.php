@if (isset($errors))
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}')
        </script>
    @endforeach
@endif
