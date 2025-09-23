@assets
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endassets
@script
    <script>
        
        window.addEventListener('notification', event => {
            
            console.log(event)
            Swal.fire({
            title: event.detail[0].title,
            text: event.detail[0].message,
            icon: event.detail[0].icon ? event.detail[0].icon : 'warning',
            confirmButtonText: 'Fermer'
            })
        })
    </script>
@endscript
@if(session()->has('success'))
    @script
        <script>
            Swal.fire({
            title: 'Success!',
            text: '{{session('success')}}',
            icon: 'success',
            confirmButtonText: 'Fermer'
            })
        </script>
    @endscript
@elseif(session()->has('warning'))
    @script
        <script>
            Swal.fire({
            title: 'Warning!',
            text: '{{session('warning')}}',
            icon: 'warning',
            confirmButtonText: 'Fermer'
            })
        </script>
    @endscript
@elseif(session()->has('info'))
    @script
        <script>
            Swal.fire({
            title: 'Info!',
            text: '{{session('info')}}',
            icon: 'info',
            confirmButtonText: 'Fermer'
            })
        </script>
    @endscript

@elseif(session()->has('error'))
    @script
        <script>
            Swal.fire({
            title: 'Error!',
            text: '{{session('error')}}',
            icon: 'error',
            confirmButtonText: 'Fermer'
            })
        </script>
    @endscript  
@endif

@if ($errors->any())
    @script
        <script>
            Swal.fire({
            title: 'Error!',
            text: 'Veuillez verifier les informations saisies',
            icon: 'error',
            confirmButtonText: 'Fermer'
            })
        </script>
    @endscript
@endif