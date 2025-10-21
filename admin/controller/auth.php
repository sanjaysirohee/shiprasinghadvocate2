<?php
session_start();
include_once ('../database/connectdb.php');
if (isset($_POST['btn_login'])) {
    $username = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = md5(mysqli_real_escape_string($con, $_POST['password']));

    if ($username != '' && $password != '') {

        $query = mysqli_query($con, "select * from tbl_admin where user_name='" . $username . "' and password='" . $password . "'") or die(mysqli_error());
        $res = mysqli_fetch_array($query);

        if ($res) {

            $_SESSION['isloginur'] = $username;

            header('location:../index.php');
        } else {
            $_SESSION['Not_match'] = 'Password Not Match';
            header('location:../login.php');
        }
    } else {
        $_SESSION['Not_match'] = 'Password Not Match';
        header('location:../login.php');
    }
}

$userSession = $_SESSION['isloginur'];

/////////////////////////////////////////////////////  add doctor
if (isset($_POST['btn_add_doctor']) && !empty($userSession)) {

    $doc_name = $_POST['doc_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $speciality = implode(',', $_POST['speciality']);
    //$description=$_POST['description'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $seo_title = $_POST['seo_title'];
    $seo_description = $_POST['seo_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];
    $branch = implode(',', $_POST['branch']);


    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $doc_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    //   $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    //     $width = $fileinfo[0];
    //     $height = $fileinfo[1];
    //     $errors     = array();
    //     $maxsize    = 300000;
    //     $acceptable = array(

    //         'image/jpeg',
    //         'image/jpg',
    //         'image/png'
    //     );

    // if ($width > "500" || $height > "300") {
    //     $errors = 'Image dimension should be within 500X300.';
    //     $_SESSION['errors']=$errors;
    //     header('location:../add-doctor.php');
    // }

    // if(($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
    //     $errors= 'File too large. File must be less than 300 kb.';
    //       $_SESSION['errors']=$errors;
    //     header('location:../add-doctor.php');

    // }

    // if((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
    //     $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
    //       $_SESSION['errors']=$errors;
    //     header('location:../add-doctor.php');

    // }



    // if(count($errors) === 0) {

    $img = $doc_name . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
    $tmp = $_FILES['uploaded_file']['tmp_name'];
    move_uploaded_file($tmp, "../../images/doc_pic/$img");

    $query = mysqli_query($con, "insert into tbl_doctor (doctor_name,dob,gender,profile_img,speciality,description,slug,seo_title,seo_description,meta_keyword,ogtitle,ogdescription,ogimage,twittertitle,twitterdescription,twitterimage,canonical,status,branch) values ('$doc_name','$dob','$gender','$img','$speciality','$description','$slug','$seo_title','$seo_description','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical','Active','$branch')");
    if ($query) {
        $_SESSION['add_doc'] = 'Doctor Added Successfully..';
        header('location:../manage-doctor.php');
    } else
        echo $con->error;

    // } 




}
////////////////////////////////////// Delete doctors
if (isset($_GET['doctor_id']) && !empty($userSession)) {
    $doctor_id = $_GET['doctor_id'];
    $image = $_GET['image'];
    $file_pointer = "../doc_pic/$image";
    unlink($file_pointer);
    $query = mysqli_query($con, "delete from tbl_doctor where doctor_id='$doctor_id'");
    if ($query) {
        $_SESSION['del_doc'] = 'Doctor Deleted Successfully..';
        header('location:../manage-doctor.php');
    }
}

////////////////////////////////////////////////// update doctors
if (isset($_POST['btn_update_doctor']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $doc_name = $_POST['doc_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $speciality = implode(',', $_POST['speciality']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $seo_title = $_POST['seo_title'];
    $seo_description = $_POST['seo_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];
    $branch = implode(',', $_POST['branch']);

    $i = $_FILES['uploaded_file']['name'];
    if (!$i == '') {
        $img = $doc_name . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../../images/doc_pic/$img");
    } else {
        $img = $_POST['old_img'];
    }


    $query = mysqli_query($con, "update tbl_doctor set doctor_name='$doc_name',dob='$dob',gender='$gender',profile_img='$img',speciality='$speciality',description='$description',seo_title='$seo_title',seo_description='$seo_description',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',branch='$branch' where doctor_id='$update_id'");
    if ($query) {
        $_SESSION['update_doc'] = 'Successfully Update Doctor Detail..';
        header('location:../manage-doctor.php');
    }
}



/////////////////////////////////////////// Add Branch 
if (isset($_POST['add_branch']) && !empty($userSession)) {

    $branch_name = $_POST['branch_name'];
    $contact_no = $_POST['contact_no'];
    $branch_location = $_POST['branch_location'];
    $branch_description = $_POST['branch_description'];
    $seo_title = $_POST['seo_title'];
    $seo_description = $_POST['seo_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $branch_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');






    $img = $branch_name . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
    $tmp = $_FILES['uploaded_file']['tmp_name'];
    move_uploaded_file($tmp, "../images/branch_image/$img");


    $query = mysqli_query($con, "insert into tbl_branch (branch_name,contact_no,branch_location,branch_image,branch_description,slug,seo_title,seo_des,'$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical') values ('$branch_name','$contact_no','$branch_location','$img','$branch_description','$slug','$seo_title','$seo_description','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical')");
    if ($query) {
        $_SESSION['add_branch'] = 'Branch Added Successfully..';
        header('location:../add-branch.php');
    }
}

/////////////////////////////////////////////// Del Branch
if (isset($_GET['branch_id']) && !empty($userSession)) {
    $branch_id = $_GET['branch_id'];
    $branch_image = $_GET['branch_image'];

    $query = mysqli_query($con, "delete from tbl_branch where branch_id='$branch_id'");
    if ($query) {
        unlink('../images/branch_image/' . $branch_image);
        $_SESSION['del_branch'] = 'Successfully Deleted Branches';
        header('location:../manage-branch.php');
    }
}
/////////////////////////////////////////////////////// Branch Update
if (isset($_POST['update_branch']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $branch_name = $_POST['branch_name'];
    $contact_no = $_POST['contact_no'];
    $branch_location = $_POST['branch_location'];
    $branch_description = $_POST['branch_description'];
    $seo_title = $_POST['seo_title'];
    $seo_description = $_POST['seo_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $branch_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');


    if ($_FILES["uploaded_file"]["name"] !== '') {

        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 300000;
        $acceptable = array(

            'image/jpeg',
            'image/jpg',
            'image/png'
        );

        if ($width != "920" || $height != "540") {
            $errors = 'Image dimension should be within 920X540.';
            $_SESSION['errors_branch_update'] = $errors;
            header('location:../add-branch.php?branch_id=' . $update_id);
        }

        if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
            $errors = 'File too large. File must be less than 300 kb.';
            $_SESSION['errors_branch_update'] = $errors;
            header('location:../add-branch.php?branch_id=' . $update_id);
        }

        if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
            $_SESSION['errors_branch_update'] = $errors;
            header('location:../add-branch.php?branch_id=' . $update_id);
        }
        $img = $branch_name . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/branch_image/$img");
    } else {
        $img = $_POST['old_image'];
    }

    $query = mysqli_query($con, "update tbl_branch set branch_name='$branch_name',contact_no='$contact_no',branch_location='$branch_location',branch_image='$img',branch_description='$branch_description',slug='$slug',seo_title='$seo_title',seo_des='$seo_description',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical' where branch_id='$update_id'");
    if ($query) {
        $_SESSION['update_branch'] = 'Branch Updated Successfully..';
        header('location:../manage-branch.php');
    }
}

////////////////////////////////////// add specialities
if (isset($_POST['btn_add_specialities']) && !empty($userSession)) {
    $speciality_name = $_POST['speciality_name'];
    $speciality_description = $_POST['speciality_description'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];
    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $speciality_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $img2 = $_FILES['uploaded_file2']['name'] ?? '';
    $tmp2 = $_FILES['uploaded_file2']['tmp_name'] ?? '';
    move_uploaded_file($tmp2, "../images/speciality/$img2");

    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 500000;
    $acceptable = array(

        'image/jpeg',
        'image/jpg',
        'image/png'
    );

    if ($width > "400" || $height > "250") {
        $errors = 'Image dimension should be within 400X250.';
        $_SESSION['errors_speciality'] = $errors;
        header('location:../add-specialities.php');
    }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {

        $errors = 'File too large. File must be less than 500 kb.';
        $_SESSION['errors_speciality'] = $errors;
        header('location:../add-specialities.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
        $_SESSION['errors_speciality'] = $errors;
        header('location:../add-specialities.php');
    } else {
        $img = 'Spiciality_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/speciality/colored/$img");

        $query = mysqli_query($con, "insert into tbl_specialities(specialities_name,specialities_des,slug,seo_title,seo_des,image,banner_image) values ('$speciality_name','$speciality_description','$slug','$seo_title','$seo_des','$img','$img2')");



        if ($query) {
            $_SESSION['add_specialities'] = 'Successfully Added Specialities..';
            header('location:../add-specialities.php');
        }
    }
}

//////////////////////////////////////// Delete specialities
if (isset($_GET['specialities_id']) && !empty($userSession)) {
    $specialities_id = $_GET['specialities_id'];
    $query = mysqli_query($con, "delete from tbl_specialities where specialities_id='$specialities_id'");
    if ($query) {
        $_SESSION['del_specialities'] = 'Successfully Deleted Specialities..';
        header('location:../manage-specialities.php');
    }
}

///////////////////////////////////////// Update specialities
if (isset($_POST['btn_Update_specialities']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $speciality_name = $_POST['speciality_name'];
    $speciality_description = $_POST['speciality_description'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $speciality_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $img2 = $_FILES['uploaded_file2']['name'];
    $tmp2 = $_FILES['uploaded_file2']['tmp_name'];
    move_uploaded_file($tmp2, "../images/speciality/$img2");


    if ($_FILES["uploaded_file"]["name"] !== '') {
        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 500000;
        $acceptable = array(

            'image/jpeg',
            'image/jpg',
            'image/png'
        );

        if ($width > "400" || $height > "250") {
            $errors = 'Image dimension should be within 400X250.';
            $_SESSION['errors_speciality'] = $errors;
            header('location:../add-specialities.php');
        }

        if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {

            $errors = 'File too large. File must be less than 500 kb.';
            $_SESSION['errors_speciality'] = $errors;
            header('location:../add-specialities.php');
        }

        if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
            $_SESSION['errors_speciality'] = $errors;
            header('location:../add-specialities.php');
        }

        $img = 'Spiciality_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/speciality/colored/$img");
    } else {
        $img = $_POST['image'];
    }


    $query = mysqli_query($con, "update tbl_specialities set specialities_name='$speciality_name',specialities_des='$speciality_description',slug='$slug',seo_title='$seo_title',seo_des='$seo_des',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',image = '$img' ,banner_image = '$img2' where specialities_id='$update_id'");

    if ($query) {
        $_SESSION['update_specialities'] = 'Successfully Update Specialities..';
        header('location:../manage-specialities.php');
    }
}

///////////////////////////////////// Add schedule
if (isset($_POST['btn_add_schedule']) && !empty($userSession)) {
    $branch_name = $_POST['branch_name'];
    $Doctors = $_POST['Doctors'];
    $shift = $_POST['shift'];
    $from_time = $_POST['from_time'];
    $to_time = $_POST['to_time'];
    @$mon = $_POST['mon'];
    @$tue = $_POST['tue'];
    @$wed = $_POST['wed'];
    @$thu = $_POST['thu'];
    @$fri = $_POST['fri'];
    @$sat = $_POST['sat'];


    $query = mysqli_query($con, "insert into tbl_schedule(branch_name,doctors_name,shift,from_time,to_time,mon,tue,wed,thu,fri,sat) values ('$branch_name','$Doctors','$shift','$from_time','$to_time','$mon','$tue','$wed','$thu','$fri','$sat')");

    if ($query) {
        $_SESSION['add_schedule'] = 'Successfully Schedule Created..';
        header('location:../add-schedule.php');
    }
}

//////////////////////////////////////// Del Schedule
if (isset($_GET['schedule_id']) && !empty($userSession)) {
    $schedule_id = $_GET['schedule_id'];
    $query = mysqli_query($con, "delete from tbl_schedule where schedule_id='$schedule_id'");
    if ($query) {
        $_SESSION['del_schedule'] = 'Successfully Deleted Schedule..';
        header('location:../manage-schedule.php');
    }
}
///////////////////////////////////////// Update Schedule
if (isset($_POST['btn_update_schedule']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $branch_name = $_POST['branch_name'];
    $Doctors = $_POST['Doctors'];
    $shift = $_POST['shift'];
    $from_time = $_POST['from_time'];
    $to_time = $_POST['to_time'];
    @$mon = $_POST['mon'];
    @$tue = $_POST['tue'];
    @$wed = $_POST['wed'];
    @$thu = $_POST['thu'];
    @$fri = $_POST['fri'];
    @$sat = $_POST['sat'];


    $query = mysqli_query($con, "update tbl_schedule set branch_name='$branch_name',doctors_name='$Doctors',shift='$shift',from_time='$from_time',to_time='$to_time',mon='$mon',tue='$tue',wed='$wed',thu='$thu',fri='$fri',sat='$sat' where schedule_id='$update_id'");

    if ($query) {
        $_SESSION['update_schedule'] = 'Successfully Schedule Updated..';
        header('location:../manage-schedule.php');
    }
}
//////////////////////////////////////////// del appointment list
if (isset($_GET['list_id']) && !empty($userSession)) {
    $list_id = $_GET['list_id'];

    $query = mysqli_query($con, "delete from tbl_appoint_list where list_id='$list_id'");
    if ($query) {
        $_SESSION['del_appointment_list'] = 'Successfully Deleted Appointment Detail.';
        header('location:../appointment-list.php');
    }
}

/////////////////////////////////////  add international page detail
if (isset($_POST['btn_international']) && !empty($userSession)) {
    $page_title = $_POST['page_title'];
    $page_description = $_POST['page_description'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];


    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $page_title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "insert into tbl_international (page_title,page_desc,slug,seo_title,seo_des) values ('$page_title','$page_description','$slug','$seo_title','$seo_des','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical')");
    if ($query) {
        $_SESSION['add_international'] = 'Successfully Added Page Detail..';
        header('location:../add-content-page.php');
    }
}
///////////////////////////////// del content 
if (isset($_GET['content_id']) && !empty($userSession)) {
    $content_id = $_GET['content_id'];
    $query = mysqli_query($con, "delete from tbl_international where page_id='$content_id'");
    if ($query) {
        $_SESSION['del_page'] = 'Successfully Deleted Page..';
        header('location:manage-content-page.php');
    }
}
/////////////////////////////////////////////////////////update content
if (isset($_POST['btn_update_international']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];

    $page_title = $_POST['page_title'];
    $page_description = $_POST['page_description'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $page_title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "update tbl_international set page_title='$page_title',page_desc='$page_description',slug='$slug',seo_title='$seo_title',seo_des='$seo_des',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical' where page_id='$update_id'");
    if ($query) {
        $_SESSION['update_international'] = 'Successfully Update Page Detail..';
        header('location:../manage-content-page.php');
    }
}

////////////////////////////////////////////////////////// add package
if (isset($_POST['health_packages']) && !empty($userSession)) {
    $package_name = $_POST['package_name'];
    $Till_date = date_format(date_create($_POST['Till_date']), 'Y-m-d');
    $Package_price = $_POST['Package_price'];
    $package_des = $_POST['package_des'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../../images/health_images/$img");

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $package_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "insert into tbl_health_package (package_name,package_till_date,package_price,package_description,seo_title,seo_des,meta_keyword,ogtitle,ogdescription,ogimage,twittertitle,twitterdescription,twitterimage,canonical,slug,image) 
  values('$package_name','$Till_date','$Package_price','$package_des','$seo_title','$seo_des','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical','$slug','$img')");
    if ($query) {
        $_SESSION['add_health_package'] = 'Successfully Added Health Packages.';
        header('location:../add-health-packages.php');
    }
}

//////////////////////////////////////// delete package
if (isset($_GET['package_id']) && !empty($userSession)) {
    $package_id = $_GET['package_id'];
    $query = mysqli_query($con, "delete from tbl_health_package where package_id='$package_id'");
    if ($query) {
        $_SESSION['Del_packages'] = 'Successfully Deleted Packages';
        header('location:../manage-health-packages.php');
    }
}

////////////////////////////////////////// update health package
if (isset($_POST['health_update_packages']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];

    $package_name = $_POST['package_name'];
    $Till_date = date_format(date_create($_POST['Till_date']), 'Y-m-d');
    $Package_price = $_POST['Package_price'];
    $package_des = $_POST['package_des'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];
    $img = $_POST['old_img'];
    if ($_FILES['image']['name'] !== '') {
        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../../images/health_images/$img");
    } else {
        $img = $_POST['old_img'];
    }

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $package_name)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "update tbl_health_package set package_name='$package_name',package_till_date='$Till_date',package_price='$Package_price',
  package_description='$package_des',seo_title='$seo_title',seo_des='$seo_des',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',slug='$slug',image='$img' where package_id='$update_id'");

    if ($query) {
        $_SESSION['update_health_package'] = 'Successfully Updated Health Packages.';
        header('location:../manage-health-packages.php');
    }
}

/////////////////////////////////////// Add Blog 
if (isset($_POST['btn_add_blog']) && !empty($userSession)) {
    $blog_heading = $con->real_escape_string($_POST['blog_heading']);
    $blog_auther = $con->real_escape_string($_POST['blog_auther']);
    $blog_description = $con->real_escape_string($_POST['blog_description']);
    $seo_title = $con->real_escape_string($_POST['seo_title']);
    $seo_des = $con->real_escape_string($_POST['seo_des']);
    $meta_keyword = $con->real_escape_string($_POST['meta_keyword']);
    $ogtitle = $con->real_escape_string($_POST['ogtitle']);
    $ogdescription = $con->real_escape_string($_POST['ogdescription']);
    $ogimage = $con->real_escape_string($_POST['ogimage']);
    $twittertitle = $con->real_escape_string($_POST['twittertitle']);
    $twitterdescription = $con->real_escape_string($_POST['twitterdescription']);
    $twitterimage = $con->real_escape_string($_POST['twitterimage']);
    $canonical = $con->real_escape_string($_POST['canonical']);
    $blogUrl = $con->real_escape_string($_POST['blogUrl']);
    $altTag = $con->real_escape_string($_POST['altTag']);
    $published = $con->real_escape_string($_POST['is_published']);
    $popular = $con->real_escape_string($_POST['is_popular']);

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $blogUrl)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $today = date('Y-m-d');


    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 90000;
    $acceptable = array(
        'image/webp'
    );

    // if ($width >= "800" && $height >= "400") {
    //     $errors = 'Image dimension should be within 800X400.';
    //     $_SESSION['errors_blog'] = $errors;
    //     header('location:../add-blog.php');
    // }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
        $errors = 'File too large. File must be less than 90 kb.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-blog.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only webp types are accepted.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-blog.php');
    }

    $fileinfothumb = @getimagesize($_FILES["uploaded_thumb_file"]["tmp_name"]);
    $widththumb = $fileinfo[0];
    $heightthumb = $fileinfo[1];
    $errors = array();
    $maxsizethumb = 90000;
    $acceptablethumb = array(
        'image/webp'
    );

    // if ($widththumb >= "350" && $heightthumb >= "250") {
    //     $errors = 'Thumb image dimension should be within 350X250.';
    //     $_SESSION['errors_blog'] = $errors;
    //     header('location:../add-blog.php');
    // }

    if (($_FILES['uploaded_thumb_file']['size'] >= $maxsizethumb) || ($_FILES["uploaded_thumb_file"]["size"] == 0)) {
        $errors = 'Thumb file too large. File must be less than 90 kb.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-blog.php');
    }

    if ((!in_array($_FILES['uploaded_thumb_file']['type'], $acceptablethumb)) && (!empty($_FILES["uploaded_thumb_file"]["type"]))) {
        $errors = 'Invalid thumb file type. Only webp types are accepted.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-blog.php');
    }

    $sql = "SELECT * FROM tbl_blog WHERE slug = '$slug'";
    $result = $con->query($sql);

    if ($result->num_rows != 0) {
        $errors = 'This blog is already exist';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-blog.php');
    }

    if (count($errors) === 0) {
        $img = $slug . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/blog/$img");

        $thumbimg = $slug . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_thumb_file']['name'];
        $thumbtmp = $_FILES['uploaded_thumb_file']['tmp_name'];
        move_uploaded_file($thumbtmp, "../images/blog/thumb/$thumbimg");


        $query = mysqli_query($con, "insert into tbl_blog (blog_heading,blog_auther,blog_image,thumb_image,blog_description,date,slug,seo_title,seo_des,meta_keyword,ogtitle,ogdescription,ogimage,twittertitle,twitterdescription,twitterimage,canonical,ogimage_alt_tag,is_published,is_popular) values ('$blog_heading','$blog_auther','$img','$thumbimg','$blog_description','$today','$slug','$seo_title','$seo_des','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical','$altTag','$published','$popular')");
        if ($query) {
            $_SESSION['add_blog'] = 'Blog Added Successfully..';
            header('location:../add-blog.php');
        }
    }
}

////////////////////////////////// del blog
if (isset($_GET['blog_id']) && !empty($userSession)) {
    $blog_id = $_GET['blog_id'];
    $query = mysqli_query($con, "delete from tbl_blog where blog_id='$blog_id'");
    if ($query) {
        $_SESSION['del_blog'] = 'Deleted Successfully..';
        header('location:../manage-blog.php');
    }
}

/////////////////////////////////////// update blog 
if (isset($_POST['btn_update_blog']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];

    $update_id = $con->real_escape_string($_POST['update_id']);
    $blog_heading = $con->real_escape_string($_POST['blog_heading']);
    $blog_auther = $con->real_escape_string($_POST['blog_auther']);
    $blog_description = $con->real_escape_string($_POST['blog_description']);
    $seo_title = $con->real_escape_string($_POST['seo_title']);
    $seo_des = $con->real_escape_string($_POST['seo_des']);
    $meta_keyword = $con->real_escape_string($_POST['meta_keyword']);
    $ogtitle = $con->real_escape_string($_POST['ogtitle']);
    $ogdescription = $con->real_escape_string($_POST['ogdescription']);
    $ogimage = $con->real_escape_string($_POST['ogimage']);
    $twittertitle = $con->real_escape_string($_POST['twittertitle']);
    $twitterdescription = $con->real_escape_string($_POST['twitterdescription']);
    $twitterimage = $con->real_escape_string($_POST['twitterimage']);
    $canonical = $con->real_escape_string($_POST['canonical']);
    $blogUrl = $con->real_escape_string($_POST['blogUrl']);
    $altTag = $con->real_escape_string($_POST['altTag']);
    $published = $con->real_escape_string($_POST['is_published']);
    $popular = $con->real_escape_string($_POST['is_popular']);

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $blogUrl)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $today = date('Y-m-d');

    if ($_FILES["uploaded_file"]["name"] !== '') {

        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 90000;
        $acceptable = array(
            'image/webp'
        );

        // if ($width >= "800" && $height >= "400") {
        //     $errors = 'Image dimension should be within 1000X730.';
        //     $_SESSION['errors_blog'] = $errors;
        //     header('location:../add-blog.php?blog_id=' . $update_id);
        // }

        if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
            $errors = 'File too large. File must be less than 90 kb.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-blog.php?blog_id=' . $update_id);
        }

        if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only webp types are accepted.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-blog.php?blog_id=' . $update_id);
        }

        $img = $slug . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/blog/$img");
    } else {
        $img = $_POST['old_image'];
    }

    if ($_FILES["uploaded_thumb_file"]["name"] !== '') {
        $fileinfothumb = @getimagesize($_FILES["uploaded_thumb_file"]["tmp_name"]);
        $widththumb = $fileinfo[0];
        $heightthumb = $fileinfo[1];
        $errors = array();
        $maxsizethumb = 90000;
        $acceptablethumb = array(
            'image/webp'
        );

        // if ($widththumb >= "350" && $heightthumb >= "250") {
        //     $errors = 'Thumb image dimension should be within 1000X730.';
        //     $_SESSION['errors_blog'] = $errors;
        //     header('location:../add-blog.php');
        // }

        if (($_FILES['uploaded_thumb_file']['size'] >= $maxsizethumb) || ($_FILES["uploaded_thumb_file"]["size"] == 0)) {
            $errors = 'Thumb file too large. File must be less than 90 kb.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-blog.php');
        }

        if ((!in_array($_FILES['uploaded_thumb_file']['type'], $acceptablethumb)) && (!empty($_FILES["uploaded_thumb_file"]["type"]))) {
            $errors = 'Invalid thumb file type. Only webp types are accepted.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-blog.php');
        }

        $thumbimg = $blog_heading . '_' . rand('100', '10000') . '_' . $_FILES['uploaded_thumb_file']['name'];
        $thumbtmp = $_FILES['uploaded_thumb_file']['tmp_name'];
        move_uploaded_file($thumbtmp, "../images/blog/thumb/$thumbimg");
    } else {
        $thumbimg = $_POST['old_thumb_image'];
    }
    $query = mysqli_query($con, "update tbl_blog set blog_heading='$blog_heading',blog_auther='$blog_auther',blog_image='$img',thumb_image='$thumbimg',blog_description='$blog_description',slug='$slug',seo_title='$seo_title',seo_des='$seo_des',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',ogimage_alt_tag='$altTag',is_published='$published',is_popular='$popular' where blog_id='$update_id'");

    if ($query) {
        $_SESSION['update_blog'] = 'Blog Updated Successfully..';
        header('location:../manage-blog.php');
    }
}

//////////////////////////////////////// add location

if (isset($_POST['btn_add_location']) && !empty($userSession)) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $seo_title = $con->real_escape_string($_POST['seo_title']);
    $seo_des = $con->real_escape_string($_POST['seo_des']);
    $meta_keyword = $con->real_escape_string($_POST['meta_keyword']);
    $ogtitle = $con->real_escape_string($_POST['ogtitle']);
    $ogdescription = $con->real_escape_string($_POST['ogdescription']);
    $ogimage = $con->real_escape_string($_POST['ogimage']);
    $twittertitle = $con->real_escape_string($_POST['twittertitle']);
    $twitterdescription = $con->real_escape_string($_POST['twitterdescription']);
    $twitterimage = $con->real_escape_string($_POST['twitterimage']);
    $canonical = $con->real_escape_string($_POST['canonical']);
    $blogUrl = $con->real_escape_string($_POST['blogUrl']);
    $city = $con->real_escape_string($_POST['city']);

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $blogUrl)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $today = date('Y-m-d');

    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 90000;
    $acceptable = array(
        'image/webp'
    );

    // if ($width >= "800" || $height >= "400") {
    //     $errors = 'Image dimension should be within 800X400.';
    //     $_SESSION['errors_blog'] = $errors;
    //     header('location:../add-location.php');
    // }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
        $errors = 'File too large. File must be less than 90 kb.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-location.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only webp types are accepted.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-location.php');
    }

    // echo "ss";

    // die;

    if (count($errors) === 0) {
        $img = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/locations/$img");

    }



    $fileinfo1 = @getimagesize($_FILES["uploaded_t_file"]["tmp_name"]);
    $width1 = $fileinfo1[0];
    $height1 = $fileinfo1[1];
    $errors1 = array();
    $maxsize1 = 90000;
    $acceptable1 = array(
        'image/webp',
    );

    // if ($width1 >= "400" || $height1 >= "400") {
    //     $errors1 = 'Image dimension should be within 400X400.';
    //     $_SESSION['errors_blog'] = $errors1;
    //     header('location:../add-location.php');
    // }

    if (($_FILES['uploaded_t_file']['size'] >= $maxsize1) || ($_FILES["uploaded_t_file"]["size"] == 0)) {
        $errors1 = 'File too large. File must be less than 90 kb.';
        $_SESSION['errors_blog'] = $errors1;
        header('location:../add-location.php');
    }

    if ((!in_array($_FILES['uploaded_t_file']['type'], $acceptable1)) && (!empty($_FILES["uploaded_t_file"]["type"]))) {
        $errors1 = 'Invalid file type. Only webp types are accepted.';
        $_SESSION['errors_blog'] = $errors1;
        header('location:../add-location.php');
    }



    if (count($errors1) === 0) {
        $img1 = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_t_file']['name'];
        $tmp1 = $_FILES['uploaded_t_file']['tmp_name'];
        move_uploaded_file($tmp1, "../images/locations/$img1");

        $user = $_SESSION['isloginur'];
        $query = mysqli_query($con, "insert into tbl_location (name,image,thumb_img,description,status,created_by,slug,seo_title,seo_des,meta_keyword,ogtitle,ogdescription,ogimage,twittertitle,twitterdescription,twitterimage,canonical,city_id) values ('$name','$img','$img1','$description','$status','$user','$slug','$seo_title','$seo_des','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical','$city')");

        if ($query) {
            $_SESSION['add_location'] = 'Location Added Successfully..';
            header('location:../add-location.php');
        }
    }
}

if (isset($_POST['btn_update_loaction']) && !empty($userSession)) {

    $update_id = $_POST['update_id'];

    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $seo_title = $con->real_escape_string($_POST['seo_title']);
    $seo_des = $con->real_escape_string($_POST['seo_des']);
    $meta_keyword = $con->real_escape_string($_POST['meta_keyword']);
    $ogtitle = $con->real_escape_string($_POST['ogtitle']);
    $ogdescription = $con->real_escape_string($_POST['ogdescription']);
    $ogimage = $con->real_escape_string($_POST['ogimage']);
    $twittertitle = $con->real_escape_string($_POST['twittertitle']);
    $twitterdescription = $con->real_escape_string($_POST['twitterdescription']);
    $twitterimage = $con->real_escape_string($_POST['twitterimage']);
    $canonical = $con->real_escape_string($_POST['canonical']);
    $blogUrl = $con->real_escape_string($_POST['blogUrl']);
    $city = $con->real_escape_string($_POST['city']);

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $blogUrl)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $today = date('Y-m-d H:i:s');

    if ($_FILES["uploaded_file"]["name"] !== '') {

        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 90000;
        $acceptable = array(
            'image/webp'
        );

        // if ($width == "1000" || $height == "730") {
        //     $errors = 'Image dimension should be within 1000X730.';
        //     $_SESSION['errors_blog'] = $errors;
        //     header('location:../add-location.php');
        // }

        if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
            $errors = 'File too large. File must be less than 90 kb.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-location.php');
        }

        if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only webp types are accepted.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-location.php');
        }
        $img = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/locations/$img");
    } else {
        $img = $_POST['old_image'];
    }

    if ($_FILES["uploaded_t_file"]["name"] !== '') {

        $fileinfo1 = @getimagesize($_FILES["uploaded_t_file"]["tmp_name"]);
        $width1 = $fileinfo1[0];
        $height1 = $fileinfo1[1];
        $errors1 = array();
        $maxsize1 = 90000;
        $acceptable1 = array(
            'image/webp'
        );

        // if ($width1 == "400" || $height1 == "400") {
        //     $errors1 = 'Image dimension should be within 1000X730.';
        //     $_SESSION['errors_blog'] = $errors1;
        //     header('location:../add-location.php');
        // }

        if (($_FILES['uploaded_t_file']['size'] >= $maxsize1) || ($_FILES["uploaded_t_file"]["size"] == 0)) {
            $errors1 = 'File too large. File must be less than 90 kb.';
            $_SESSION['errors_blog'] = $errors1;
            header('location:../add-location.php');
        }

        if ((!in_array($_FILES['uploaded_t_file']['type'], $acceptable1)) && (!empty($_FILES["uploaded_t_file"]["type"]))) {
            $errors1 = 'Invalid file type. Only webp types are accepted.';
            $_SESSION['errors_blog'] = $errors1;
            header('location:../add-location.php');
        }

        $img1 = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_t_file']['name'];
        $tmp1 = $_FILES['uploaded_t_file']['tmp_name'];
        move_uploaded_file($tmp1, "../images/locations/$img1");
    } else {
        $img1 = $_POST['old_thumb_image'];
    }

    $user = $_SESSION['isloginur'];
    $query = mysqli_query($con, "update tbl_location set name='$name',description='$description',status='$status',image='$img',thumb_img='$img1',updated_date='$today',updated_by='$user',slug='$slug',seo_title='$seo_title',seo_des='$seo_des',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',city_id='$city' where id='$update_id'");
    if ($query) {
        $_SESSION['del_location'] = 'Location Updated Successfully..';
        header('location:../manage-locations.php');
    }
}

////////////////////////////////// del location
if (isset($_GET['location_id']) && !empty($userSession)) {
    $location_id = $_GET['location_id'];
    $query = mysqli_query($con, "delete from tbl_location where id='$location_id'");
    if ($query) {
        $_SESSION['del_location'] = 'Deleted Successfully..';
        header('location:../manage-locations.php');
    }
}

//////////////////////////////////////// City start

//////////////////////////////////////// add city

if (isset($_POST['btn_add_city']) && !empty($userSession)) {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $seo_title = $con->real_escape_string($_POST['seo_title']);
    $seo_des = $con->real_escape_string($_POST['seo_des']);
    $meta_keyword = $con->real_escape_string($_POST['meta_keyword']);
    $ogtitle = $con->real_escape_string($_POST['ogtitle']);
    $ogdescription = $con->real_escape_string($_POST['ogdescription']);
    $ogimage = $con->real_escape_string($_POST['ogimage']);
    $twittertitle = $con->real_escape_string($_POST['twittertitle']);
    $twitterdescription = $con->real_escape_string($_POST['twitterdescription']);
    $twitterimage = $con->real_escape_string($_POST['twitterimage']);
    $canonical = $con->real_escape_string($_POST['canonical']);
    $blogUrl = $con->real_escape_string($_POST['blogUrl']);
    $position = $con->real_escape_string($_POST['position']);

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $blogUrl)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $today = date('Y-m-d');

    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 90000;
    $acceptable = array(
        'image/webp'
    );

    // if ($width >= "800" || $height >= "400") {
    //     $errors = 'Image dimension should be within 800X400.';
    //     $_SESSION['errors_blog'] = $errors;
    //     header('location:../add-location.php');
    // }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
        $errors = 'File too large. File must be less than 90 kb.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-location.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only webp types are accepted.';
        $_SESSION['errors_blog'] = $errors;
        header('location:../add-city.php');
    }

    // echo "ss";

    // die;

    if (count($errors) === 0) {
        $img = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/cities/$img");

    }



    $fileinfo1 = @getimagesize($_FILES["uploaded_t_file"]["tmp_name"]);
    $width1 = $fileinfo1[0];
    $height1 = $fileinfo1[1];
    $errors1 = array();
    $maxsize1 = 90000;
    $acceptable1 = array(
        'image/webp'
    );

    // if ($width1 >= "400" || $height1 >= "400") {
    //     $errors1 = 'Image dimension should be within 400X400.';
    //     $_SESSION['errors_blog'] = $errors1;
    //     header('location:../add-location.php');
    // }

    if (($_FILES['uploaded_t_file']['size'] >= $maxsize1) || ($_FILES["uploaded_t_file"]["size"] == 0)) {
        $errors1 = 'File too large. File must be less than 90 kb.';
        $_SESSION['errors_blog'] = $errors1;
        header('location:../add-location.php');
    }

    if ((!in_array($_FILES['uploaded_t_file']['type'], $acceptable1)) && (!empty($_FILES["uploaded_t_file"]["type"]))) {
        $errors1 = 'Invalid file type. Only webp types are accepted.';
        $_SESSION['errors_blog'] = $errors1;
        header('location:../add-city.php');
    }

    if (count($errors1) === 0) {
        $img1 = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_t_file']['name'];
        $tmp1 = $_FILES['uploaded_t_file']['tmp_name'];
        move_uploaded_file($tmp1, "../images/cities/thumb/$img1");

        $user = $_SESSION['isloginur'];
        $query = mysqli_query($con, "insert into tbl_cities (name,image,thumb_img,description,status,created_by,slug,seo_title,seo_des,meta_keyword,ogtitle,ogdescription,ogimage,twittertitle,twitterdescription,twitterimage,canonical,position) values ('$name','$img','$img1','$description','$status','$user','$slug','$seo_title','$seo_des','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical','$position')");

        if ($query) {
            $_SESSION['add_city'] = 'City Added Successfully..';
            header('location:../add-city.php');
        }
    }
}

if (isset($_POST['btn_update_city']) && !empty($userSession)) {

    $update_id = $_POST['update_id'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $seo_title = $con->real_escape_string($_POST['seo_title']);
    $seo_des = $con->real_escape_string($_POST['seo_des']);
    $meta_keyword = $con->real_escape_string($_POST['meta_keyword']);
    $ogtitle = $con->real_escape_string($_POST['ogtitle']);
    $ogdescription = $con->real_escape_string($_POST['ogdescription']);
    $ogimage = $con->real_escape_string($_POST['ogimage']);
    $twittertitle = $con->real_escape_string($_POST['twittertitle']);
    $twitterdescription = $con->real_escape_string($_POST['twitterdescription']);
    $twitterimage = $con->real_escape_string($_POST['twitterimage']);
    $canonical = $con->real_escape_string($_POST['canonical']);
    $blogUrl = $con->real_escape_string($_POST['blogUrl']);
    $position = $con->real_escape_string($_POST['position']);

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $blogUrl)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $today = date('Y-m-d H:i:s');

    if ($_FILES["uploaded_file"]["name"] !== '') {

        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 90000;
        $acceptable = array(
            'image/webp',
        );

        // if ($width == "1000" || $height == "730") {
        //     $errors = 'Image dimension should be within 1000X730.';
        //     $_SESSION['errors_blog'] = $errors;
        //     header('location:../add-location.php');
        // }

        if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
            $errors = 'File too large. File must be less than 90 kb.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-location.php');
        }

        if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only  webp types are accepted.';
            $_SESSION['errors_blog'] = $errors;
            header('location:../add-city.php');
        }
        $img = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/cities/$img");
    } else {
        $img = $_POST['old_image'];
    }

    if ($_FILES["uploaded_t_file"]["name"] !== '') {

        $fileinfo1 = @getimagesize($_FILES["uploaded_t_file"]["tmp_name"]);
        $width1 = $fileinfo1[0];
        $height1 = $fileinfo1[1];
        $errors1 = array();
        $maxsize1 = 90000;
        $acceptable1 = array(

            'image/webp',
        );

        // if ($width1 == "400" || $height1 == "400") {
        //     $errors1 = 'Image dimension should be within 1000X730.';
        //     $_SESSION['errors_blog'] = $errors1;
        //     header('location:../add-location.php');
        // }

        if (($_FILES['uploaded_t_file']['size'] >= $maxsize1) || ($_FILES["uploaded_t_file"]["size"] == 0)) {
            $errors1 = 'File too large. File must be less than 90 kb.';
            $_SESSION['errors_blog'] = $errors1;
            header('location:../add-location.php');
        }

        if ((!in_array($_FILES['uploaded_t_file']['type'], $acceptable1)) && (!empty($_FILES["uploaded_t_file"]["type"]))) {
            $errors1 = 'Invalid file type. Only webp types are accepted.';
            $_SESSION['errors_blog'] = $errors1;
            header('location:../add-location.php');
        }

        $img1 = 'location_' . rand('100', '10000') . '_' . $_FILES['uploaded_t_file']['name'];
        $tmp1 = $_FILES['uploaded_t_file']['tmp_name'];
        move_uploaded_file($tmp1, "../images/cities/thumb/$img1");
    } else {
        $img1 = $_POST['old_thumb_image'];
    }

    $user = $_SESSION['isloginur'];
    $query = mysqli_query($con, "update tbl_cities set name='$name',description='$description',status='$status',image='$img',thumb_img='$img1',updated_date='$today',updated_by='$user',slug='$slug',seo_title='$seo_title',seo_des='$seo_des',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',position='$position' where id='$update_id'");
    if ($query) {
        $_SESSION['del_location'] = 'Location Updated Successfully..';
        header('location:../manage-cities.php');
    }
}

////////////////////////////////// del city
if (isset($_GET['city_id']) && !empty($userSession)) {
    $city_id = $_GET['city_id'];
    $query = mysqli_query($con, "delete from tbl_cities where id='$city_id'");
    if ($query) {
        $_SESSION['del_location'] = 'Deleted Successfully..';
        header('location:../manage-cities.php');
    }
}

//////////////////////////////////////// City end

//////////////////////////////////////// add home slider 
if (isset($_POST['btn_add_slider']) && !empty($userSession)) {
    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 500000;
    $acceptable = array(

        'image/jpeg',
        'image/jpg',
        'image/png'
    );

    if ($width == "1920" || $height == "780") {
        $errors = 'Image dimension should be within 1920X780.';
        $_SESSION['errors_home'] = $errors;
        header('location:../home-slider.php');
    }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
        $errors = 'File too large. File must be less than 500 kb.';
        $_SESSION['errors_home'] = $errors;
        header('location:../home-slider.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
        $_SESSION['errors_home'] = $errors;
        header('location:../home-slider.php');
    } else {
        $img = 'Saroj Slider_' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/home_slider/$img");

        $query = mysqli_query($con, "insert into tbl_home_slider (image) values ('$img')");
        if ($query) {
            $_SESSION['add_slider'] = 'Home Slider  Added Successfully..';
            header('location:../home-slider.php');
        }
    }
}

////////////////////////////////////////////////// Add Job
if (isset($_POST['btn_add_job']) && !empty($userSession)) {
    $job_title = $_POST['job_title'];
    $position = $_POST['position'];
    $location = $_POST['location'];
    $vacancy = $_POST['vacancy'];
    $expire_date = $_POST['expire_date'];
    $job_des = $_POST['job_des'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $job_title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "insert into tbl_job (job_title,job_position,job_location,vacancy,expire_date,job_description,slug) values ('$job_title','$position','$location','$vacancy','$expire_date','$job_des','$slug')");
    if ($query) {
        $_SESSION['add_job'] = 'Successfully Added Job..';
        header('location:../add-job.php');
    }
}
/////////////////////////////////////// Del Job
if (isset($_GET['job_id']) && !empty($userSession)) {
    $job_id = $_GET['job_id'];
    $query = mysqli_query($con, "delete from tbl_job where job_id='$job_id'");
    if ($query) {
        $_SESSION['del_job'] = 'success';
        header('location:add-job.php');
    }
}

//////////////////////////////////////////////////// Update Job
if (isset($_POST['btn_update_job']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $job_title = $_POST['job_title'];
    $position = $_POST['position'];
    $location = $_POST['location'];
    $vacancy = $_POST['vacancy'];
    $expire_date = $_POST['expire_date'];
    $job_des = $_POST['job_des'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $job_title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "update tbl_job set job_title='$job_title',job_position='$position',job_location='$location',vacancy='$vacancy',expire_date='$expire_date',job_description='$job_des',slug='$slug' where job_id='$update_id'");
    if ($query) {
        $_SESSION['update_job'] = 'Successfully Update Job..';
        header('location:../manage-job.php');
    }
}

//////////////////////////////////// Add video gallery
if (isset($_POST['btn_add_vedio']) && !empty($userSession)) {
    $Video_url = $_POST['Video_url'];
    $query = mysqli_query($con, "insert into tbl_vedio (video_url) values('$Video_url')");
    if ($query) {
        $_SESSION['add_video'] = 'Successfully Added Video..';
        header('location:../add_video.php');
    }
}

////////////////////////////////// Add Gallery vidio
if (isset($_POST['btn_add_gallery']) && !empty($userSession)) {
    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 500000;
    $acceptable = array(

        'image/jpeg',
        'image/jpg',
        'image/png'
    );

    if ($width == "1000" || $height == "780") {
        $errors = 'Image dimension should be within 1000X780.';
        $_SESSION['gallery_error'] = $errors;
        header('location:../add_imgage_gallery.php');
    }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
        $errors = 'File too large. File must be less than 500 kb.';
        $_SESSION['gallery_error'] = $errors;
        header('location:../add_imgage_gallery.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
        $_SESSION['gallery_error'] = $errors;
        header('location:../add_imgage_gallery.php');
    } else {
        $img = 'Saroj Gallery' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/img_gallery/$img");

        $query = mysqli_query($con, "insert into tbl_gallery_image (image) values ('$img')");
        if ($query) {
            $_SESSION['add_image'] = 'Gallery Image Added Successfully..';
            header('location:../add_imgage_gallery.php');
        }
    }
}

/////////////////////////////////// Add News
if (isset($_POST['btn_add_news']) && !empty($userSession)) {
    $news_heading = $_POST['news_heading'];
    $news_description = $_POST['news_description'];
    $seo_title = $_POST['seo_title'];
    $seo_description = $_POST['seo_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $news_heading)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $pdf = $_FILES['pdf']['name'];
    $tmp1 = $_FILES['pdf']['tmp_name'];
    move_uploaded_file($tmp1, "../images/news/$pdf");

    $img = 'News' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
    $tmp = $_FILES['uploaded_file']['tmp_name'];
    move_uploaded_file($tmp, "../images/news/$img");

    $today = $_POST['news_date'];

    $query = mysqli_query($con, "insert into tbl_news (news_heading,news_image,news_description,slug,seo_title,seo_des,date,pdf) 
    values ('$news_heading','$img','$news_description','$slug','$seo_title','$seo_description','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical','$today','$pdf')");
    if ($query) {
        $_SESSION['add_news'] = 'Add News Added Successfully..';
        header('location:../add-news.php');
    }
}

//////////////////////////////////////// Del News
if (isset($_GET['news_id']) && !empty($userSession)) {
    $news_id = $_GET['news_id'];
    $query = mysqli_query($con, "delete from tbl_news where news_id='$news_id'");
    if ($query) {
        $_SESSION['del_news'] = 'Successfully Deleted News..';
        header('location:../manage-news.php');
    }
}

/////////////////////////////////////// update news
if (isset($_POST['btn_update_news']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $news_heading = $_POST['news_heading'];
    $news_description = $_POST['news_description'];
    $seo_title = $_POST['seo_title'];
    $seo_description = $_POST['seo_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];
    $pdf = $_FILES['pdf']['name'];
    $tmp1 = $_FILES['pdf']['tmp_name'];
    move_uploaded_file($tmp1, "../images/news/$pdf");

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $news_heading)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    if ($_FILES["uploaded_file"]["name"] !== '') {
        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 500000;
        $acceptable = array(

            'image/jpeg',
            'image/jpg',
            'image/png'
        );

        if ($width == "1000" || $height == "780") {
            $errors = 'Image dimension should be within 1000X780.';
            $_SESSION['news_error'] = $errors;
            header('location:../add-news.php?news_id=' . $update_id);
        } else if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
            $errors = 'File too large. File must be less than 500 kb.';
            $_SESSION['news_error'] = $errors;
            header('location:../add-news.php?news_id=' . $update_id);
        } else if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
            $_SESSION['news_error'] = $errors;
            header('location:../add-news.php?news_id=' . $update_id);
        } else {
            $img = 'News' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
            $tmp = $_FILES['uploaded_file']['tmp_name'];
            move_uploaded_file($tmp, "../images/news/$img");
        }
    } else {
        $img = $_POST['old_img'];
    }

    //$today=date('Y-m-d');
    $query = mysqli_query($con, "update tbl_news set news_heading='$news_heading',news_image='$img',news_description='$news_description',slug='$slug',seo_title='$seo_title'
    ,seo_des='$seo_description',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical',pdf='$pdf' where news_id='$update_id'");
    if ($query) {
        $_SESSION['update_news'] = 'update News Successfully..';
        header('location:../manage-news.php');
    }
}

/////////////////////////////////////// Add Notics
if (isset($_POST['btn_add_notics']) && !empty($userSession)) {
    $notice_heading = $_POST['notice_heading'];
    $Branch = $_POST['Branch'];
    $notice_des = $_POST['notice_des'];
    $today = date('Y-m-d');

    $query = mysqli_query($con, "insert into tbl_notice(notice_heading,branch,notice_description,date) values ('$notice_heading','$Branch','$notice_des','$today')");
    if ($query) {
        $_SESSION['add-notice'] = 'Successfully Added Notice..';
        header('location:../add-notice.php');
    }
}
////////////////////////////////////// del notice
if (isset($_GET['notice_id']) && !empty($userSession)) {
    $notice_id = $_GET['notice_id'];
    $query = mysqli_query($con, "delete from tbl_notice where notice_id='$notice_id'");
    if ($query) {
        $_SESSION['del_ notice'] = 'success';
        header('location:../manage-notice.php');
    }
}

////////////////////////////////////// Update notics
if (isset($_POST['btn_update_notics']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $notice_heading = $_POST['notice_heading'];
    $Branch = $_POST['Branch'];
    $notice_des = $_POST['notice_des'];


    $query = mysqli_query($con, "update tbl_notice set notice_heading='$notice_heading',branch='$Branch',notice_description='$notice_des' where notice_id='$update_id'");
    if ($query) {
        $_SESSION['update-notice'] = 'Successfully Update Notice..';
        header('location:../manage-notice.php');
    }
}
/////////////////////////////////// Add event 
if (isset($_POST['btn_add_event']) && !empty($userSession)) {
    $event_title = $_POST['event_title'];
    $event_date = $_POST['event_date'];
    $event_Des = $_POST['event_Des'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $event_title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $errors = array();
    $maxsize = 500000;
    $acceptable = array(

        'image/jpeg',
        'image/jpg',
        'image/png'
    );

    if ($width == "1000" || $height == "780") {
        $errors = 'Image dimension should be within 1000X780.';
        $_SESSION['event_error'] = $errors;
        header('location:../add_event.php');
    }

    if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
        $errors = 'File too large. File must be less than 500 kb.';
        $_SESSION['event_error'] = $errors;
        header('location:../add_event.php');
    }

    if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
        $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
        $_SESSION['event_error'] = $errors;
        header('location:../add_event.php');
    } else {
        $img = 'Event' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
        $tmp = $_FILES['uploaded_file']['tmp_name'];
        move_uploaded_file($tmp, "../images/event/$img");
        $today = date('Y-m-d');

        $query = mysqli_query($con, "insert into tbl_event (event_title,event_date,event_des,event_image,seo_title,seo_des,slug) values ('$event_title','$event_date','$event_Des','$img','$seo_title','$seo_des','$slug','$meta_keyword','$ogtitle','$ogdescription','$ogimage','$twittertitle','$twitterdescription','$twitterimage','$canonical')");
        if ($query) {
            $_SESSION['add_event'] = 'Add Event Added Successfully..';
            header('location:../add-event.php');
        }
    }
}

////////////////////////////////////////////// Delete Event
if (isset($_GET['event_id']) && !empty($userSession)) {
    $event_id = $_GET['event_id'];
    $query = mysqli_query($con, "delete from tbl_event where event_id='$event_id'");
    if ($query) {
        $_SESSION['del_event'] = 'Successfully Deleted Event..!';
        header('location:../manage-event.php');
    }
}

/////////////////////////////////// Update event
if (isset($_POST['btn_update_event']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $event_title = $_POST['event_title'];
    $event_date = $_POST['event_date'];
    $event_Des = $_POST['event_Des'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $meta_keyword = $_POST['meta_keyword'];
    $ogtitle = $_POST['ogtitle'];
    $ogdescription = $_POST['ogdescription'];
    $ogimage = $_POST['ogimage'];
    $twittertitle = $_POST['twittertitle'];
    $twitterdescription = $_POST['twitterdescription'];
    $twitterimage = $_POST['twitterimage'];
    $canonical = $_POST['canonical'];


    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $event_title)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    if ($_FILES["uploaded_file"]["name"] !== '') {
        $fileinfo = @getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        $errors = array();
        $maxsize = 500000;
        $acceptable = array(

            'image/jpeg',
            'image/jpg',
            'image/png'
        );

        if ($width == "1000" || $height == "780") {
            $errors = 'Image dimension should be within 1000X780.';
            $_SESSION['event_error'] = $errors;
            header('location:../add-event.php?event_id=' . $update_id);
        } else if (($_FILES['uploaded_file']['size'] >= $maxsize) || ($_FILES["uploaded_file"]["size"] == 0)) {
            $errors = 'File too large. File must be less than 500 kb.';
            $_SESSION['event_error'] = $errors;
            header('location:../add-event.php?event_id=' . $update_id);
        } else if ((!in_array($_FILES['uploaded_file']['type'], $acceptable)) && (!empty($_FILES["uploaded_file"]["type"]))) {
            $errors = 'Invalid file type. Only  JPG, JPEG and PNG types are accepted.';
            $_SESSION['event_error'] = $errors;
            header('location:../add-event.php?event_id=' . $update_id);
        } else {
            $img = 'Event' . rand('100', '10000') . '_' . $_FILES['uploaded_file']['name'];
            $tmp = $_FILES['uploaded_file']['tmp_name'];
            move_uploaded_file($tmp, "../images/event/$img");
        }
    } else {
        $img = $_POST['old_img'];
    }

    //$today=date('Y-m-d');

    $query = mysqli_query($con, "update tbl_event set event_title='$event_title',event_des='$event_Des',event_image='$img',seo_title='$seo_title',seo_des='$seo_des',slug='$slug',meta_keyword='$meta_keyword',ogtitle='$ogtitle',ogdescription='$ogdescription',ogimage='$ogimage',twittertitle='$twittertitle',twitterdescription='$twitterdescription',twitterimage='$twitterimage',canonical='$canonical' where event_id='$update_id'");
    if ($query) {
        $_SESSION['update_event'] = 'update Event Successfully..';
        header('location:../manage-news.php');
    }
}

///////////////////////////////// Add speciality terms
if (isset($_POST['btn_terms']) && !empty($userSession)) {
    $specialities_id = $_POST['specialities_id'];
    $heading = $_POST['heading'];
    $specialities_des = $_POST['specialities_des'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $seo_key = $_POST['seo_key'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $heading)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "insert into tbl_specialities_terms (heading,description,slug,seo_title,seo_des,speciality_id) values ('$heading','$specialities_des','$slug','$seo_title','$seo_des','$seo_key','$specialities_id')");
    if ($query) {
        $_SESSION['add_terms'] = 'Successfully Add Terms & Conditions..';
        header('location:../terms-and-conitions?specialities_id=' . $specialities_id);
    }
}

/////////////////////////////////// del terms
if (isset($_GET['terms_id']) && !empty($userSession)) {
    $terms_id = $_GET['terms_id'];
    $id = $_GET['id'];

    $query = mysqli_query($con, "delete from tbl_specialities_terms where terms_id='$terms_id'");
    if ($query) {
        $_SESSION['del_terms'] = 'Successfully Deleted Terms & Condition..';
        header('location:../terms-and-conitions?specialities_id=' . $id);
    }
}

////////////////////////////////////// Update Terms
if (isset($_POST['btn_update_terms']) && !empty($userSession)) {
    $update_id = $_POST['update_id'];
    $specialities_id = $_POST['specialities_id'];
    $heading = $_POST['heading'];
    $specialities_des = $_POST['specialities_des'];
    $seo_title = $_POST['seo_title'];
    $seo_des = $_POST['seo_des'];
    $seo_key = $_POST['seo_key'];

    $slug = strToLower(str_replace(" ", "-", str_replace(str_split('\/:.()*?"<>!=_|$%^&*#{}[],+`~@'), '', $heading)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $query = mysqli_query($con, "update tbl_specialities_terms set heading='$heading',description='$specialities_des',slug='$slug',seo_title='$seo_title',seo_des='$seo_des',seo_key='$seo_key' where terms_id='$update_id'");
    if ($query) {
        $_SESSION['update_terms'] = 'Successfully Update Terms & Conditions..';
        header('location:../terms-and-conitions?specialities_id=' . $specialities_id);
    }
}

/////////////////////////////////////////// add pop up image
if (isset($_POST['btn_add_pop']) && !empty($userSession)) {
    $img = rand(0, 1000) . $_FILES['uploaded_file']['name'];
    $tmp = $_FILES['uploaded_file']['tmp_name'];
    move_uploaded_file($tmp, "../../images/$img");

    $query = mysqli_query($con, "insert into tbl_popup (image) values('$img')");
    if ($query) {
        $_SESSION['popup'] = 'successfully added image..';
        header('location:../popup.php');
    }
}
