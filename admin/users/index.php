<?php global $_settings;
require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" >
<?php require_once('inc/header.php') ?>
<body class="">
<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>
<script>
    start_loader()
</script>

<div class="d-flex justify-content-center h-100 align-items-center">

    <div class="col-6 d-flex flex-column h-100 justify-content-center align-items-center bg-gradient-light">
        <div class="card card-outline card-primary my-2 rounded-0 shadow">
            <div class="card-header rounded-0">
                <h3 class="card-title font-wight-bolder">Warden Registration</h3>
            </div>
            <div class="card-body">
                <form id="aregistration-frm" action="" method="post">
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="firstname" class="control-label">First Name <sup>*</sup></label>
                            <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" required="required" autofocus>
                        </div>
                        <div class="col-md-4">
                            <label for="middlename" class="control-label">Middle Name</label>
                            <input type="text" name="middlename" id="middlename" class="form-control form-control-sm rounded-0">
                        </div>
                        <div class="col-md-4">
                            <label for="lastname" class="control-label">Last Name <sup>*</sup></label>
                            <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="gender" class="control-label">Gender <sup>*</sup></label>
                            <select name="gender" id="gender" class="form-control form-control-sm rounded-0" required="required">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="control-label">Account Type <sup>*</sup></label>
                            <select name="gender" id="gender" class="form-control form-control-sm rounded-0" required="required">
                                <option>Agent</option>
                                <option>Warden</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="contact" class="control-label">Contact # <sup>*</sup></label>
                            <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="address" class="control-label">Address <sup>*</sup></label>
                            <textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" required="required"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email" class="control-label">Email <sup>*</sup></label>
                            <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password" class="control-label">Password <sup>*</sup></label>
                            <div class="input-group input-group-sm">
                                <input type="password" name="password" id="password" class="form-control form-control-sm rounded-0" required="required">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-default rounded-0 pass_view" tabindex="-1" type="button"><i class="fa fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cpassword" class="control-label">Confirm Password <sup>*</sup></label>
                            <div class="input-group input-group-sm">
                                <input type="password" id="cpassword" class="form-control form-control-sm rounded-0" required="required">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-default rounded-0 pass_view" tabindex="-1" type="button"><i class="fa fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="custom-file custom-file-sm rounded-0">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group d-flex justify-content-center col-md-6">
                        </div>
                    </div>
                    <div class="row align-items-end">
                        
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Create Account</button>
                        </div>
                        <!-- /.col -->
                    </div>
                   
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>


<script src="plugins/jquery/jquery.min.js"></script>

<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>

<script>
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
                _this.siblings('label', input.files[0].name);
            }

            reader.readAsDataURL(input.files[0]);
        }else{
            $('#cimg').attr('src', "<?php echo validate_image('') ?>");
            _this.siblings('label','Choose File');
        }
    }
    $(document).ready(function(){
        end_loader();
        $('.pass_view').click(function(){
            const group =  $(this).closest('.input-group')
            const type = group.find('input').attr('type')
            if(type == 'password'){
                group.find('input').attr('type','text').focus()
                $(this).html("<i class='fa fa-eye'></i>")
            }else{
                group.find('input').attr('type','password').focus()
                $(this).html("<i class='fa fa-eye-slash'></i>")
            }
        })
        $('#aregistration-frm').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            var el = $('<div>')
            el.addClass('alert alert-danger err-msg')
            el.hide()
            if($("#password").val() != $("#cpassword").val()){
                el.text("Password does not match.")
                _this.prepend(el)
                el.show('slow')
                $("html, body").scrollTop(0);
                return false;
            }
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Users.php?f=save_agent",
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
                        location.href="./login.php"
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