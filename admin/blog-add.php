<?php
if (isset($_GET['p_id'])) {
	$p_id = $_GET['p_id'];
	$result_blog = mysqli_query($conn, "SELECT * FROM blogs where id = '$p_id'");
	$row_blog = mysqli_fetch_array($result_blog);


	$b_id = $row_blog["id"];
	$b_title = $row_blog["title"];
	$b_url_key = $row_blog["slug"];
	$b_description = $row_blog["description"];
	$b_category = $row_blog["category"];
	$b_status = $row_blog["status"];
	$b_publish_date = $row_blog["date"];
	$t_pro_pic = $row_blog['image'];
	$t_image =  BASE_URL . "assets/images/blogs/" . $t_pro_pic;
	$_b_url_path = BASE_URL . 'blogs/' . $b_url_key . '';
	$s_description = $row_blog["short_description"];
	$meta_title = $row_blog["meta_title"];
	$meta_description = $row_blog["meta_description"];
	$meta_keyword = $row_blog["meta_keyword"];
}

?>




<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php if (isset($_GET['p_id']) && $_GET['p_id'] > 0) {
				echo 'Edit';
			} else {
				echo 'Add';
			} ?>

			<small>Blog</small>
			<?php if (isset($_GET['p_id']) && $_GET['p_id'] > 0) { ?>
				<button class="btn bg-purple btn-flat margin" onclick="window.location.assign('<?php echo BASE_ADMIN_URL; ?>home.php?page=addblog');">Add New</button>
			<?php } ?>
		</h1>
		<ol class=" breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php if (isset($_GET['p_id']) && $_GET['p_id'] > 0) {
									echo 'Edit';
								} else {
									echo 'Add';
								} ?> Blog</li>

		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<?php if (isset($_SESSION['error'])) { ?>
					<div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
				<?php unset($_SESSION['error']);
				} ?>
				<?php if (isset($_SESSION['success'])) { ?>
					<div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
				<?php unset($_SESSION['success']);
				} ?>
				<div class="">
					<div class="">
						<?php if ($b_id > 0) { ?>
							<form role="form" action="<?php echo BASE_ADMIN_URL; ?>include/edit_blog.php" method="POST" name="blog_add_frm" id="blog_add_frm" enctype="multipart/form-data">
							<?php } else { ?>

								<form role="form" action="<?php echo BASE_ADMIN_URL; ?>include/add_blog.php" method="POST" name="blog_add_frm" id="blog_add_frm" enctype="multipart/form-data">
								<?php } ?>

								<input type="hidden" class="form-control" name="action" value="post-add" />
								<input type="hidden" class="form-control" name="b_id" value="<?php echo $b_id; ?>" />
								<div class="col-xs-12 col-md-9">
									<div class="box  box-body box-default">
										<div class=" ">
											<!-- text input -->
											<div class="form-group">
												<div class="box-header">
													<h3 class="box-title">Title </h3>

												</div><!-- /.box-header -->
												<input type="text" class="form-control required" placeholder="Enter title here..." name="title" id="title" value="<?php echo $b_title; ?>" style=" font-size: 24px;" required>

											</div>
											<div class="form-group">

												<span class="form-control b_url_path" disabled> <label>Blog Url: </label> <?php echo $_b_url_path; ?></span>
											</div>
											<div class="form-group">
												<input type="hidden" name="b_url_key" id="b_url_key" value="<?php echo $b_url_key; ?>">
											</div>
											<div class="form-group">
												<div class="box-header">
													<h3 class="box-title">Category</h3>
												</div>
												<select class="form-control required" name="category" id="category">
													<?php

													$sql3 = 'SELECT * FROM blog_category';
													$result3 = mysqli_query($conn, $sql3);
													while ($row = mysqli_fetch_array($result3)) {

													?>
														<option value="<?php echo $row['id']; ?>" <?php if ($cat == $row['id']) { ?> Selected <?php } ?>><?php echo $row['name']; ?></option>
													<?php } ?>
												</select>
												<!-- <select class="form-control required" name="category" id="category">
															<option value="publish"> Published </option>
														</select> -->

											</div>
											<div class="form-group">
												<div class="box-header">
													<h3 class="box-title">Short Description </h3>
												</div>
												<!-- <textarea id="s_desc" name="s_description" rows="20" cols="80"  placeholder="Place some text here" style="resize:none" class="required" required >
															<?php echo $s_description; ?>
														</textarea> -->
												<input type="text" class="form-control required" placeholder="Enter Short desc here..." name="s_description" id="s_description" value="<?php echo $s_description; ?>" style=" font-size: 24px;" required>
											</div>

											<div class="box-header">
												<h3 class="box-title">Detail <small>Blog Descripton</small></h3>

											</div><!-- /.box-header -->
											<div class="box-body pad">
												<textarea id="editor1" name="editor1" rows="20" cols="80" placeholder="Place some text here" style="resize:none" class="required" required>
															<?php echo $b_description; ?>
														</textarea>

											</div>


										</div>

									</div><!-- box -->

									<div class="box   box-default">
										<div class="box-header with-border">
											<h3 class="box-title">Metadata</h3>
											<div class="box-tools pull-right">
												<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

											</div>
										</div><!-- /.box-header -->
										<div class="box-body">
											<div class="form-group">
												<strong>Title</strong>
												<input type="text" class="form-control" placeholder="Enter meta title here..." name="meta_title" value="<?php echo $meta_title; ?>">
												<p class="help-block">Enter a custom title to be used in the title HTML element of the page.</p>


											</div>
											<div class="form-group">
												<strong>Description</strong>
												<textarea id="meta_description" class="form-control" name="meta_description" rows="3" cols="80" placeholder="Place meta description here" style="resize:none"><?php echo $meta_description; ?></textarea>
												<p class="help-block">Enter a custom description of 30-50 words (based on an average word length of 5 characters).</p>

											</div>
											<div class="form-group">
												<strong>Keywords</strong>
												<input type="text" class="form-control" placeholder="Enter meta keywords here..." name="meta_keyword" value="<?php echo $meta_keyword; ?>">
												<p class="help-block">Enter keywords separated with commas.</p>
												<p class="help-block">Important note: for security reasons only meta elements are allowed in this box. All other HTML elements are automatically removed.</p>
											</div>
										</div><!-- box-body -->
									</div><!-- box -->




								</div><!-- col-md-9 -->



								<div class="col-md-3 col-xs-12">
									<div class="box box-info">
										<div class="box-header with-border">
											<h3 class="box-title">Publish</h3>
										</div><!-- /.box-header -->
										<div class="box-body">
											<div class="input-group">
												<!--	<p><i class="fa fa-map-pin" aria-hidden="true"></i>  -->
												<span class="input-group-addon"><i class="fa fa-map-pin"></i> </span>
												<select class="form-control required" name="b_status" id="b_status">
													<option value="publish" <?php if ($b_status == 'publish') {
																				echo 'selected';
																			} ?>>Published</option>
													<option value="pending" <?php if ($b_status == 'pending') {
																				echo 'selected';
																			} ?>>Draft</option>

												</select>
											</div>
											<p></p>
											<?php if ($b_status == 'publish') { ?>
												<p><i class="fa fa-calendar" aria-hidden="true"></i> Published on <b><?php echo $b_publish_date; ?></b></p>
											<?php } else { ?>
												<p><i class="fa fa-calendar" aria-hidden="true"></i> Publish Immediately <b><?php echo $b_publish_date; ?></b></p>

											<?php } ?>
											<p></p>

											<div class="form-group">

												<input type="submit" class="btn btn-info pull-right" name="b_submit" value="Publish">
											</div>
										</div>

									</div>
									<div class="box box-info">
										<div class="box-header with-border">
											<h3 class="box-title">Featured Image</h3>
										</div><!-- /.box-header -->
										<div class="box-body image-holder-1">
											<?php if ($t_pro_pic != '' && @getimagesize($t_image)) { ?>

												<header class="entry-header">
													<input type="hidden" class="" name="b_old_image" id="b_old_image" value="<?php echo $t_pro_pic; ?>">
													<div class="entry-thumbnail" id="b_image">
														<img src='<?php echo $t_image; ?>' id='image-holder' class='img-responsive center-block' alt="<?php echo $b_title; ?> <?php echo $b_title; ?>" />
													</div>
													<p class="help-block">Click below to edit or update</p>
													<p><a href="javascript:void(0);" id="del_img">Delete Image</a></p>
													<p><a href="javascript:void(0);" id="chnfti">Change Featured Image</a></p>
												</header>
											<?php } else { ?>
												<img src='<?php echo $t_image; ?>' id='image-holder' class='img-responsive center-block' />
												<p><a href="javascript:void(0);" id="delt_img" style="display: none;">Delete Image</a></p>
											<?php } ?>
											<div class="form-group featured_div <?php if ($t_pro_pic != '' && @getimagesize($t_image)) { ?> hidden <?php } ?> >
														<label for=" b_featured_image">Set Featured Image</label>
												<input type="file" id="b_featured_image" name="b_featured_image">

											</div>
										</div>
									</div>
								</div>

								</form>



					</div><!-- /.box body-->
				</div><!-- /.box -->
			</div><!-- /.box -->




		</div><!-- /.col -->

		<!-- <div class="row">
					<div class="col-xs-12 col-md-9">		
						<?php
						$comnt_query = "SELECT  * FROM   blog_comment  WHERE id = " . $b_id . " Order By c_comment_date DESC";
						$comnt_result = mysqli_query($conn, $comnt_query);
						$comment_count = mysqli_num_rows($comnt_result);
						?>
							
						<div class="box   box-default" >
							<div class="box-header with-border">
								<h3 class="box-title">Comments</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								
								</div>
								</div>
								<div class="box-body bg-gray">
									<div class="panel panel-default">
										<div class="panel-body">
										<form action="<?php echo BASE_ADMIN_URL; ?>include/add_comment.php" method="post" id="comment_form" name="comment_form">
											<div class="form-group ">
												<textarea class="form-control required " placeholder="Write comment here" name="c_message" ></textarea>
													
											</div>
												
											<div  class="form-group" >
												<input type="hidden" class="form-control " value="<?php echo $b_id; ?>" name="b_id" />
												<input type="hidden" class="form-control " value="comment-add" name="action" />
												<input type="submit" value="Add Comment"  class="btn btn-primary pull-right " name="comntbtn"/> 
											</div>
										</form>
										</div>
									</div>
								<?php if ($comment_count > 0) { ?>
								<?php while ($comnt_row = mysqli_fetch_assoc($comnt_result)) { ?>
								<?php
										$c_id = $comnt_row['c_id'];
										$c_email = $comnt_row['c_email'];
										$c_name = $comnt_row['c_name'];
										$c_message = $comnt_row['c_message'];
										$c_comment_date = date('d M, Y', strtotime($comnt_row['c_comment_date']));
								?>
									
									<div class="panel  panel-default" >
									<div class="panel-body">
									<dl class="dl-horizontal" >
										<dt><?php echo $c_name; ?><br/> <?php echo $c_email; ?> <br/><?php echo $c_comment_date; ?></dt>
										<dd><?php echo $c_message; ?></dd>
									</dl>
									</div>	
									</div>
									
									<?php } ?>
									<?php } else {  ?>
										<h3 class="comments-title"> 0 Comment </h3>
									<?php } ?>
								</div>
							</div>
							
					</div> 
				</div> -->


	</section>
</div>

<script>
	$(document).ready(function() {

		// place this within dom ready function
		function showpanel() {
			var str = $("#title").val();
			if (str != '' && str.length > 2) {
				var dt = new Date($.now());
				var curr_date = dt.getDate();
				var curr_month = dt.getMonth();
				var curr_year = dt.getFullYear();
				var arch = curr_year + '-' + curr_month + '-' + curr_date;
				//var str = "Sonic Free Games";
				str = str.replace('\'', '').toLowerCase();
				str = str.replace('\"', '').toLowerCase();
				str = str.replace('\/', '').toLowerCase();
				str = str.replace('?', '').toLowerCase();
				str = str.replace(':', '').toLowerCase();
				str = str.replace(';', '').toLowerCase();
				str = str.replace(',', '').toLowerCase();
				str = str.replace('%', '').toLowerCase();
				str = str.replace('@', '').toLowerCase();
				str = str.replace(/\s+/g, '-').toLowerCase();
				// var b_url_path = '<?php echo $site_url; ?>blogs/'+arch+'/'+str+'';
				var b_url_path = '<?php echo BASE_URL; ?>blogs/' + str + '';
				$(".b_url_path")('<label>Blog Url: </label> ' + b_url_path + '');
				//$("#b_url_key").val(arch+'/'+str);
				$("#b_url_key").val(str);
				// alert(curr_year+'-'+curr_month+'-'+curr_date);

			}
		}
		<?php //if($b_id < 1 ) { 
		?>
		$("#title").keyup(function() {
			// alert('sdsds');
			setTimeout(showpanel, 2000);
		});
		// use setTimeout() to execute
		// setTimeout(showpanel, 10000);
		<?php //} 
		?>

		$('#chnfti').click(function() {
			$('.featured_div').toggleClass('hidden');

		});
	});
</script>

<script type="text/javascript">
	function readURL(input) {
		var imgPath = input.value;
		var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		var image_holder = $("#image-holder");
		image_holder.empty();
		if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
			if (typeof(FileReader) != "undefined") {
				var reader = new FileReader();

				reader.onload = function(e) {
					$('#image-holder').attr('src', e.target.result);
					$('#delt_img').show();
				}
				image_holder.show();
				reader.readAsDataURL(input.files[0]);
			} else {
				alert("This browser does not support FileReader.");
				input.value = null;
			}
		} else {
			alert("Pls select only images");
			input.value = null;
		}
	}

	$("#b_featured_image").change(function() {
		readURL(this);
	});

	$("#del_img").click(function() {
		$("#b_image")('');
		$("#b_old_image").val('');

	});
	$("#delt_img").click(function() {
		$('#image-holder').attr('src', '');
		$("#delt_img").hide();
		$('#b_featured_image').val('');

	});
</script>