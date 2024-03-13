<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
        <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Real Estate Types</span>
                <span class="info-box-number">
                  <?php
                    $types = $conn->query("SELECT * FROM type_list")->num_rows;
                    echo format_num($types);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-star"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Amenities</span>
                <span class="info-box-number">
                  <?php
                    $amenities = $conn->query("SELECT * FROM amenity_list ")->num_rows;
                    echo format_num($amenities);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-map-marker-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Available</span>
                <span class="info-box-number">
                  <?php 
                    $available = $conn->query("SELECT * FROM real_estate_list ")->num_rows;
                    echo format_num($available);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-map-marker-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Unvailable</span>
                <span class="info-box-number">
                  <?php 
                    $available = $conn->query("SELECT * FROM real_estate_list ")->num_rows;
                    echo format_num($available);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  
    
</div>
