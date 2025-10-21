<?php
#################################################
# This file is used to configuration of database# 
# detail to use connectivity with database      #
#################################################

$con = mysqli_connect('localhost', DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('MySQL connect failed. ' . mysqli_error());
