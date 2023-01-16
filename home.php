<?php include('db_connect.php') ?>

<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM users where type = 3")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>

<?php else: ?>
  <!-- getting user id.............. -->
  <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Welcome <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Quiz</span>
                <span class="info-box-number">
                <?php echo $conn->query("SELECT * FROM quiz")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Item Quiz</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM quiz_item")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
<?php endif; ?>
