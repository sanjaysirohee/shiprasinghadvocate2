<?php

include_once ('header.php');

@$location_id = $_GET['location_id'];

$fetch_detail = mysqli_query($con, "select * from tbl_location where id='$location_id'");

$res_detail = mysqli_fetch_array($fetch_detail);


$fetch_cities = mysqli_query($con, "select * from tbl_cities");


?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Location</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active">Add Location</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $location_id != '' ? 'Update' : 'Add' ?> Location</h5>
                        <form class="form-material form-horizontal" action="controller/auth.php" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="update_id" value="<?= $res_detail['id']; ?>">
                            <?php
                            if (isset($_SESSION['add_location'])) {

                                ?>

                                <div class="alert alert-success alert-dismissible" id="success_alert" style="

    color: white;

    background: #b73a3a;

">

                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                    <strong>
                                        <?= $_SESSION['add_location']; ?>
                                    </strong>

                                </div>

                                <?php

                                unset($_SESSION['add_location']);
                            }

                            ?>

                            <?php
                            if (isset($_SESSION['errors_blog'])) {

                                ?>

                                <div class="alert alert-success alert-dismissible" id="success_alert" style="

    color: white;

    background: #b73a3a;

">

                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                    <strong>
                                        <?= $_SESSION['errors_blog']; ?>
                                    </strong>

                                </div>

                                <?php

                                unset($_SESSION['errors_blog']);
                            }

                            ?>

                            <div class="form-group">

                                <label class="col-md-12" for="example-text">City</span>

                                </label>
                                <div class="col-md-12">
                                    <select name="city" class="form-control" required>
                                        <option value="">Select</option>
                                        <?php
                                        while ($city = $res_cities = mysqli_fetch_array($fetch_cities)) {

                                            ?>
                                            <option value="<?php echo $city['id'] ?>" <?php echo $res_detail['city_id'] == $city['id'] ? 'selected' : '' ?>>
                                                <?php echo $city['name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>


                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-md-12" for="fetch-title">Name</span>

                                </label>

                                <div class="col-md-12">

                                    <input type="text" id="fetch-title" name="name" class="form-control"
                                        placeholder="Enter Location Name" value="<?= $res_detail['name']; ?>" required>

                                </div>

                            </div>


                            <div class="form-group">

                                <?php

                                if (isset($_GET['location_id'])) {

                                    ?>

                                    <img src="../admin/images/locations/<?= $res_detail['image']; ?>"
                                        style="max-width: 20%;">

                                    <?php

                                }

                                ?>



                                <label class="col-sm-12">Location Thumb Image</label>

                                <div class="col-sm-12">

                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">

                                        <input type="hidden" name="old_image" value="<?= $res_detail['image']; ?>">



                                        <input type="file" name="uploaded_file" <?php echo (($location_id == "") ? "required" : ""); ?>> </span>
                                    </div>

                                </div>



                            </div>

                            <div class="form-group">

                                <?php

                                if (isset($_GET['location_id'])) {

                                    ?>

                                    <img src="../admin/images/locations/<?= $res_detail['thumb_img']; ?>"
                                        style="max-width: 20%;">

                                    <?php

                                }

                                ?>



                                <label class="col-sm-12">Location Details Image</label>

                                <div class="col-sm-12">

                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">

                                        <input type="hidden" name="old_thumb_image"
                                            value="<?= $res_detail['thumb_img']; ?>">



                                        <input type="file" name="uploaded_t_file" <?php echo (($location_id == "") ? "required" : ""); ?>> </span>
                                    </div>

                                </div>



                            </div>


                            <div class="form-group">

                                <label class="col-md-12">Location Description</label>

                                <div class="col-md-12">

                                    <textarea cols="50" id="editor1" name="description" rows="10" required><?= $res_detail['description']; ?>

                   </textarea>

                                </div>

                            </div>


                            <!--  -->


                            <div class="form-group">

                                <label class="col-md-12" for="example-text">SEO Title</span>

                                </label>

                                <div class="col-md-12">

                                    <input type="text" id="example-text" name="seo_title" class="form-control"
                                        placeholder="Enter SEO Title" value="<?= $res_detail['seo_title']; ?>">

                                </div>

                            </div>



                            <div class="form-group">

                                <label class="col-md-12" for="example-text">SEO Description</span>

                                </label>

                                <div class="col-md-12">

                                    <textarea type="text" id="example-text" name="seo_des" class="form-control"
                                        placeholder="Enter SEO Description"><?= $res_detail['seo_des']; ?></textarea>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-md-12" for="example-text">SEO Keywords</span>

                                </label>

                                <div class="col-md-12">



                                    <textarea cols="100" id="editor1" name="meta_keyword" rows="10" required><?= $res_detail['meta_keyword']; ?>

                        </textarea>



                                </div>

                            </div>



                            <h3 style="padding-left: 10px;"> OG Tag</h3>



                            <div class="">



                                <div class="form-group">

                                    <label class="col-md-12" for="example-text">OG Title</span>

                                    </label>

                                    <div class="col-md-12">





                                        <input type="text" id="example-text" name="ogtitle" class="form-control"
                                            placeholder="Enter OG Title" value="<?= $res_detail['ogtitle']; ?>">

                                    </div>

                                </div>





                                <div class="form-group">

                                    <label class="col-md-12" for="example-text">OG Description</span>

                                    </label>

                                    <div class="col-md-12">





                                        <input type="text" id="example-text" name="ogdescription" class="form-control"
                                            placeholder="Enter OG Description"
                                            value="<?= $res_detail['ogdescription']; ?>">

                                    </div>

                                </div>

                            </div>

                    </div>

                    <div class="">





                        <div class="form-group">

                            <label class="col-md-12" for="example-text">OG Image</span>

                            </label>

                            <div class="col-md-12">





                                <input type="text" id="example-text" name="ogimage" class="form-control"
                                    placeholder="Enter OG Image" value="<?= $res_detail['ogimage']; ?>">

                            </div>

                        </div>



                    </div>



                    <h3 style="padding-left: 10px;">For Twitter</h3>







                    <div class="form-group">

                        <label class="col-md-12" for="example-text">Twitter Title</span>

                        </label>

                        <div class="col-md-12">





                            <input type="text" id="example-text" name="twittertitle" class="form-control"
                                placeholder="Enter OG Title" value="<?= $res_detail['twittertitle']; ?>">

                        </div>

                    </div>







                    <div class="form-group">

                        <label class="col-md-12" for="example-text">Twitter Description</span>

                        </label>

                        <div class="col-md-12">



                            <input type="text" id="example-text" name="twitterdescription" class="form-control"
                                placeholder="EnterTwitter Description"
                                value="<?= $res_detail['twitterdescription']; ?>">

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-md-12" for="blogUrl">Location_url</span>

                        </label>

                        <div class="col-md-12">

                            <input type="text" id="blogUrl" name="blogUrl" class="form-control"
                                placeholder="Enter blog url" value="<?= str_replace('-', ' ', $res_detail['slug']); ?>">

                        </div>

                    </div>

                </div>

                <div class="row">



                    <div class="form-group">

                        <label class="col-md-12" for="example-text">Twitter Image</span>

                        </label>

                        <div class="col-md-12">





                            <input type="text" id="example-text" name="twitterimage" class="form-control"
                                placeholder="EnterTwitter Image" value="<?= $res_detail['twitterimage']; ?>">

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-md-12" for="example-text">Canonical</span>

                        </label>

                        <div class="col-md-12">





                            <input type="text" id="example-text" name="canonical" class="form-control"
                                placeholder="Enter Canonical" value="<?= $res_detail['canonical']; ?>">

                        </div>

                    </div>

                    <!--  -->

                    <div class="form-group">

                        <label class="col-md-12" for="example-text">Published</span>

                        </label>

                        <div class="col-md-12">
                            <select name="status" class="form-control">
                                <option value="">Select</option>
                                <option value="1" <?php echo $res_detail['status'] == '1' ? 'selected' : '' ?>>Enable
                                </option>
                                <option value="0" <?php echo $res_detail['status'] == '0' ? 'selected' : '' ?>>Disable
                                </option>
                            </select>
                        </div>

                    </div>





                </div>

                <?php

                if (isset($_GET['location_id'])) {

                    ?>

                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"
                        name="btn_update_loaction">Update</button>

                    <?php

                } else {

                    ?>

                    <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"
                        name="btn_add_location">Submit</button>

                    <?php

                }

                ?>







                </form>

            </div>

        </div>

    </div>

</div>





<div class="right-sidebar">

    <div class="slimscrollright">

        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>

        <div class="r-panel-body">

            <ul id="themecolors" class="m-t-20">

                <li><b>With Light sidebar</b></li>

                <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme">1</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme working">6</a></li>

                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>

                <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>

                <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>

            </ul>

            <ul class="m-t-20 chatonline">

                <li><b>Chat option</b></li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/1.jpg" alt="user-img" class="img-circle">
                        <span>Varun Dhavan <small class="text-success">online</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/2.jpg" alt="user-img" class="img-circle">
                        <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/3.jpg" alt="user-img" class="img-circle">
                        <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/4.jpg" alt="user-img" class="img-circle">
                        <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/5.jpg" alt="user-img" class="img-circle">
                        <span>Govinda Star <small class="text-success">online</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/6.jpg" alt="user-img" class="img-circle">
                        <span>John Abraham<small class="text-success">online</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/7.jpg" alt="user-img" class="img-circle">
                        <span>Hritik Roshan<small class="text-success">online</small></span></a>

                </li>

                <li>

                    <a href="javascript:void(0)"><img src="assets/images/users/8.jpg" alt="user-img" class="img-circle">
                        <span>Pwandeep rajan <small class="text-success">online</small></span></a>

                </li>

            </ul>

        </div>

    </div>

</div>

<!-- ============================================================== -->

<!-- End Right sidebar -->

<!-- ============================================================== -->

</div>

<!-- ============================================================== -->

<!-- End Container fluid  -->

<!-- ============================================================== -->

</div>

<!-- ============================================================== -->

<!-- End Page wrapper  -->

<!-- ============================================================== -->

<!-- ============================================================== -->

<!-- footer -->

<!-- ============================================================== -->

<?php

include_once ('footer.php');

?>
<?php if($location_id == '') {?>
<script>
    $('#fetch-title').on('mouseleave', function () {
        var value = $(this).val();
        $('#blogUrl').val(value);
    })
</script>
<?php } ?>