<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT r.*,t.name as rtype FROM `real_estate_list` r inner join `type_list` t on r.type_id = t.id where r.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
        if(isset($id)){
            $meta_qry = $conn->query("SELECT * FROM `real_estate_meta` where real_estate_id = '{$id}'");
            while($row = $meta_qry->fetch_assoc()){
                ${$row['meta_field']} = $row['meta_value'];
            }

            $amenity_arr = [];
            $amentiy_qry = $conn->query("SELECT * FROM `amenity_list` where id in (SELECT `amenity_id` FROM `real_estate_amenities` where real_estate_id = '{$id}') order by `name`");
            while($row = $amentiy_qry->fetch_assoc()){
                $amenity_arr[$row['type']][] = $row;
            }
        }
        if(isset($agent_id)){
            $agent_det = [];
            $agent = $conn->query("SELECT *,CONCAT(lastname,', ', firstname, ' ', COALESCE(middlename,''))as fullname FROM `agent_list` where id = '{$agent_id}' ");
            $agent_det = $agent->fetch_array();
        }
    }else{
        echo '<script> alert("Unknown Real Estate\'s ID."); location.replace("./?page=real_estate"); </script>';
    }
}else{
    echo '<script> alert("Real Estate\'s ID is required to access the page."); location.replace("./?page=real_estate"); </script>';
}
?>
<style>
    .view-image img{
        width:100%;
        height:10vh;
        object-fit:scale-down;
        object-position: center center;
    }
    .mapouter{position:relative;text-align:right;height:500px;width:100%;}
    .gmap_canvas {overflow:hidden;background:none!important;height:500px;width:100%;}
</style>
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h4 class="card-title">Estate Details: <b><?= isset($code) ? $code : "" ?></b></h4>
        </div>
        <div class="card-body">
            <div class="row gx-4 gx-lg-5 align-items-top">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0 border border-dark" loading="lazy" id="display-img" src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" alt="..." />
                    <div class="mt-2 row gx-2 gx-lg-3 row-cols-4 row-cols-md-3 row-cols-xl-4 justify-content-start">
                        <div class="col">
                            <a href="javascript:void(0)" class="view-image active"><img src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                        </div>
                        <?php 
                        if(isset($id)):
                        if(is_dir(base_app."uploads/estate_".$id)):
                        $fileO = scandir(base_app."uploads/estate_".$id);
                            foreach($fileO as $k => $img):
                                if(in_array($img,array('.','..')))
                                    continue;
                        ?>
                        <div class="col">
                            <a href="javascript:void(0)" class="view-image"><img src="<?php echo validate_image('uploads/estate_'.$id.'/'.$img."?v=".strtotime($date_updated)) ?>" loading="lazy"  class="img-thumbnail bg-gradient-dark" alt=""></a>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- <div class="small mb-1">SKU: BST-498</div> -->
                    <h1 class="display-5 fw-bolder border-bottom border-primary pb-1"><?php echo $name ?></h1>
                    <p class="m-0"><small><?= $rtype ?></small></p>
                    <fieldset>
                        <legend class="h4 text-muted">Details</legend>
                        <div class="row">
                            <div class="col-6">
                                <span class="text-muted">Type: </span><?= isset($type) ? $type : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Purpose: </span><?= isset($purpose) ? $purpose : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Area: </span><?= isset($area) ? $area : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Sale Price: </span><?= isset($sale_price) ? format_num($sale_price) : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Location: </span><?= isset($location) ? $location : '' ?>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Status: </span> 
                                <?php if(isset($status) && $status == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Available</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </fieldset>
                    <p class="lead"><?php echo stripslashes(html_entity_decode($description)) ?></p>
                    <fieldset>
                        <legend class="h4 text-muted">Amenities</legend>
                        <?php  if(isset($amenity_arr) && count($amenity_arr) > 0): ?>
                        <?php  if(isset($amenity_arr[1]) && count($amenity_arr[1]) > 0): ?>
                            <div><b>Indoor(s):</b></div>
                            <div class="row">
                            <?php foreach($amenity_arr[1] as $v): ?>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <span class="badge badge-success text-light rounded mr-2"><i class="fa fa-check"></i></span> <?= $v['name'] ?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div><b>Outdoor(s):</b></div>
                            <div class="row">
                            <?php foreach($amenity_arr[2] as $v): ?>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <span class="badge badge-success text-light rounded mr-2"><i class="fa fa-check"></i></span> <?= $v['name'] ?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php else: ?>
                            <center><small class="text-mute"><i>No Amenities listed.</i></small></center>
                        <?php endif; ?>
                    </fieldset>
                </div>
            </div>
            <?php if(isset($coordinates)): ?>
            <div class="row">
                <div class="col-md-12">
                    <h4>Map Location</h4>
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?= str_replace(" ","",$coordinates) ?>&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                    <div class="card card-outline card-info rounded-0 shadow">
                        <div class="card-header">
                            <h4 class="cart-title"><b>Agent Details:</b></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <img src="<?= validate_image(isset($agent_det['avatar']) ? $agent_det['avatar'] : "") ?>" alt="Agent Image" class="img-fluid img-thumbnail w-100 bg-gradient-gray border" id="agent-avatar">
                                </div>
                                <div class="col-8">
                                    <dl>
                                        <dt class="text-muted"><b>Fullname</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['fullname']) ? $agent_det['fullname'] : "" ?></dd>
                                        <dt class="text-muted"><b>Contact #</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['contact']) ? $agent_det['contact'] : "" ?></dd>
                                        <dt class="text-muted"><b>Email</b></dt>
                                        <dd class="pl-2"><?= isset($agent_det['email']) ? $agent_det['email'] : "" ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(function(){
    $('.view-image').click(function(){
        var _img = $(this).find('img').attr('src');
        $('#display-img').attr('src',_img);
        $('.view-image').removeClass("active")
        $(this).addClass("active")
    })
    $('#delete_estate').click(function(){
        _conf("Are you sure to delete this Real Estate permanently?","delete_estate",[])
    })
})
function delete_estate($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_estate",
			method:"POST",
			data:{id: '<?= isset($id) ? $id : "" ?>'},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('./?page=real_estate');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>