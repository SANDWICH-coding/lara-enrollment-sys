@extends('layouts.app')

{{-- Customize layout sections --}}


{{-- Content body: main page content --}}



{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}

@endpush

{{-- Push extra scripts --}}

@push('js')
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@endpush