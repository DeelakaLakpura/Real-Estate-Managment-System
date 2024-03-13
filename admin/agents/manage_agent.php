<?php 
if(isset($_GET['id'])){
	$agent = $conn->query("SELECT * FROM agent_list where id ='{$_GET['id']}'");
	foreach($agent->fetch_array() as $k =>$v){
		if(!is_numeric($k))
			$$k = $v;
	}
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-agent">	
				<input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-4">
						<label for="firstname" class="control-label">First Name <sup>*</sup></label>
						<input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($firstname) ? $firstname : "" ?>" autofocus>
					</div>
					<div class="col-md-4">
						<label for="middlename" class="control-label">Middle Name</label>
						<input type="text" name="middlename" id="middlename" class="form-control form-control-sm rounded-0" value="<?=isset($middlename) ? $middlename : "" ?>">
					</div>
					<div class="col-md-4">
						<label for="lastname" class="control-label">Last Name <sup>*</sup></label>
						<input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($lastname) ? $lastname : "" ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="gender" class="control-label">Gender <sup>*</sup></label>
						<select name="gender" id="gender" class="form-control form-control-sm rounded-0" required="required">
							<option <?=isset($gender) && $gender == 'Male' ? "selected" : "" ?>>Male</option>
							<option <?=isset($gender) && $gender == 'Female' ? "selected" : "" ?>>Female</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="contact" class="control-label">Contact # <sup>*</sup></label>
						<input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($contact) ? $contact : "" ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="address" class="control-label">Address <sup>*</sup></label>
						<textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" required="required"><?=isset($address) ? $address : "" ?></textarea>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<label for="email" class="control-label">Email <sup>*</sup></label>
						<input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" required="required" value="<?=isset($email) ? $email : "" ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="password" class="control-label">New Password <sup>*</sup></label>
						<div class="input-group input-group-sm">
							<input type="password" name="password" id="password" class="form-control form-control-sm rounded-0">
							<div class="input-group-append">
								<button class="btn btn-outline-default rounded-0 pass_view" tabindex="-1" type="button"><i class="fa fa-eye-slash"></i></button>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<label for="" class="control-label">Avatar</label>
						<div class="custom-file custom-file-sm rounded-0">
							<input type="file" class="custom-file-input rounded-0 form-control-sm" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
							<label class="custom-file-label rounded-0" for="customFile">Choose file</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group d-flex justify-content-center col-md-6">
						<img src="<?php echo validate_image(isset($avatar) ? $avatar : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="status" class="control-label">Status <sup>*</sup></label>
						<select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
							<option value="1" <?=isset($status) && $status == '1' ? "selected" : "" ?>>Active</option>
							<option value="0" <?=isset($status) && $status == '0' ? "selected" : "" ?>>Inactive</option>
						</select>
					</div>

				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-agent">Update</button>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', "<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>");
		}
	}
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
	$('#manage-agent').submit(function(e){
        e.preventDefault();
        var _this = $(this)
            $('.err-msg').remove();
        var el = $('<div>')
            el.addClass('alert alert-danger err-msg')
            el.hide()
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
                    location.reload();
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

</script>