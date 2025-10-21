<style>
  a {
    color: unset;
  }
</style>
<?php
// include "../config.php" ; 
// $sql111 = "Select b.*, bc.id,bc.name as name From blogs as b left join blog_category as bc on b.category = bc.id ORDER BY b.id desc" ;
$sql111 = "select * from blogs ORDER BY id desc";
$result = mysqli_query($conn, $sql111);
?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Blog <small>List</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo BASE_ADMIN_URL; ?>home.php?page=blog"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Blogs</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <!-- <h3 class="box-title">Blogs</h3> -->
          </div>
          <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
              <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']);
          } ?>
          <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
              <?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']);
          } ?>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="blog-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <!-- <th>Category</th> -->
                  <th>Author</th>
                  <th><i class="fa fa-comment" aria-hidden="true"></i></th>
                  <th>Keywords</th>
                  <th><i class="fa fa-calendar" aria-hidden="true"></i> Date</th>
                  <th>Featured Image</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                  <?php
                  $t_pro_pic = $row['image'];
                  $t_image = BASE_URL . "assets/images/blogs/" . $t_pro_pic;
                  ?>
                  <tr>
                    <td>
                      <a href="<?php echo BASE_ADMIN_URL; ?>home.php?page=addblog&p_id=<?php echo $row['id']; ?>">
                        <?php echo $row['title']; ?>
                      </a><br />

                      <a href="<?php echo BASE_ADMIN_URL; ?>home.php?page=addblog&p_id=<?php echo $row['id']; ?>"><span
                          class="label label-warning">Edit</span></a>

                      <a href="<?php echo BASE_URL; ?>blog/<?php echo $row['b_url_key']; ?>" target="_blank"><span
                          class="label label-info">View</span> </a>

                      <a
                        href="<?php echo BASE_ADMIN_URL; ?>include/statusprocess.php?action=blogdelete&p_id=<?php echo $row['id']; ?>"><span
                          class="label label-danger confirm">Delete</span></a>
                    </td>

                    <td>Santosh University</td>
                    <td>12</td>
                    <td>
                      <?php echo $row['meta_keyword']; ?>
                    </td>
                    <td>
                      <?php echo date('d M, Y', strtotime($row['date'])); ?><br /><span>
                        <?php echo $row['status']; ?>
                    </td>
                    <td><img src='../<?php echo $t_image ?>' class='img-responsive center-block'
                        alt="<?php echo $row['b_title']; ?> " width="70" />
                    </td>


                  </tr>
                <?php } ?>
              </tbody>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(function () {
    $('.confirm').click(function () {
      return window.confirm("Are you sure?");
    });
  });
</script>

<script>
  $(document).ready(function () {
    $('#blog-table').DataTable({
      "order": [
        [3, "desc"]
      ]
    });
  });
</script>