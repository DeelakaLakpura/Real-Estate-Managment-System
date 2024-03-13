<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<header>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

</header>
<?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
<script>
    start_loader()
</script>
<style>
    body{
        background-image: url("https://i.ibb.co/2s2vt1R/New-Project-5.png");
        background-size:cover;
        background-repeat:no-repeat;
        backdrop-filter: contrast(1);
    }

</style>
<div class="login-box">
    <?php if($_settings->chk_flashdata('success')): ?>
        <script>
            alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
        </script>
    <?php endif;?>
    <!-- /.login-logo -->
    <div class="flex justify-center items-center h-screen ">
        <div class="max-w-md w-full">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                <p class="text-center text-2xl text-gray-800 mb-8">Please enter your credentials</p>
                <form id="login-agent-form" action="" method="post">

                    <div class="mb-6 relative">
                        <div class="flex">
                            <span class="bg-gray-200 rounded-l-md px-3 py-2 flex items-center"><i class="fas fa-envelope"></i></span>
                            <input type="text" class="form-input rounded-none rounded-r-md block w-full pl-3" name="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="mb-6 relative">
                        <div class="flex">
                            <span class="bg-gray-200 rounded-l-md px-3 py-2 flex items-center"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-input rounded-none rounded-r-md block w-full pl-3" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="<?php echo base_url ?>" class="text-sm text-blue-500 hover:underline">Go to Website</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-none rounded-r-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">Sign In</button>
                    </div>
                    <div class="text-center mt-4">
                        <a href="<?php echo base_url ?>warden/registration.php" class="text-sm text-gray-600 hover:underline">Create New Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- /.login-box -->

    <!-- jQuery -->
    <!-- <script src="plugins/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap 4 -->
    <!-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- AdminLTE App -->
    <!-- <script src="dist/js/adminlte.min.js"></script> -->

    <script>
        $(document).ready(function(){
            end_loader();
            $('#login-agent-form').submit(function(e){
                e.preventDefault();
                var _this = $(this)
                $('.err-msg').remove();
                var el = $('<div>')
                el.addClass('alert alert-danger err-msg')
                el.hide()
                start_loader();
                $.ajax({
                    url:_base_url_+"classes/Login.php?f=login_agent",
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    dataType: 'json',
                    error:err=>{
                        console.log(err)
                        alert_toast("An error occured",'error');
                        end_loader();
                    },
                    success:function(resp){
                        if(typeof resp =='object' && resp.status == 'success'){
                            location.href=_base_url_+"warden"
                        }else if(resp.status == 'failed' && !!resp.msg){
                            el.text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                            end_loader()
                        }else{
                            alert_toast("An error occured",'error');
                            end_loader();
                            console.log(resp)
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>