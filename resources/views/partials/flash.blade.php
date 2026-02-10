<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: "{{ session('success') }}",
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    @endif

    @if($errors->any())
        let errorMessages = "";
        @foreach($errors->all() as $error)
            errorMessages += "- {{ $error }}\n";
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Ada Kesalahan!',
            text: errorMessages,
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    @endif
</script>
