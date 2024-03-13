<header>
    <!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</header>
<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e){
    e.preventDefault()
     var sTxt = $('[name="search"]').val()
     if(sTxt != '')
      location.href = './?p=products&search='+sTxt;
  })
</script>
<?php include './HomePage/head.php'?>

<div class="container-fluid nav-bar bg-transparent">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
        <a href="index.php" class="navbar-brand d-flex align-items-center text-center">
            <div class="icon p-2 me-2">
                <img class="img-fluid"  width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy" src="https://i.ibb.co/2spHqKN/logo-1.png" >

            </div>
            <h1 class="m-0 text-primary">Dormitory Discover</h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto">
                <a href="./"  class="nav-item nav-link active">Home</a>
                <a href="./?p=about" class="nav-item nav-link">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Agents</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="./agent" class="dropdown-item">Agent Login</a>
                        <a href="./agent/registration.php" class="dropdown-item">Agent Registration</a>

                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Warden</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="./warden/login.php" class="dropdown-item">Warden Login</a>
                        <!-- <a href="./warden/registration.php" class="dropdown-item">Warden Registration</a> -->

                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Admin</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="./admin" class="dropdown-item">Admin Login</a>

                    </div>
                </div>
                <a href="#" id="contactLink" class="nav-item nav-link">Contact</a>
            </div>
            <a href="./agent/registration.php" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a>
        </div>
    </nav>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the "Contact" link element
    var contactLink = document.getElementById('contactLink');

    // Add click event listener
    contactLink.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action (redirecting)

        // Show SweetAlert modal
        Swal.fire({
            title: 'Contact Us',
            html: '<input id="swal-input1" class="swal2-input" placeholder="Name">' +
                  '<input id="swal-input2" class="swal2-input" placeholder="Email">' +
                  '<textarea id="swal-input3" class="swal2-textarea" placeholder="Message"></textarea>',
            showCancelButton: true,
            confirmButtonText: 'Send',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                // Retrieve input values
                const name = Swal.getPopup().querySelector('#swal-input1').value;
                const email = Swal.getPopup().querySelector('#swal-input2').value;
                const message = Swal.getPopup().querySelector('#swal-input3').value;

                // You can process the input values here (e.g., send them to a server)
                // For now, we'll just log them to the console
                console.log('Name: ' + name);
                console.log('Email: ' + email);
                console.log('Message: ' + message);
            }
        });
    });
});
</script>

