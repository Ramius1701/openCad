<?php

session_start();
	
if (empty($_SESSION['logged_in']))
{
	header('Location: ../index.php');
    die("Not logged in");
}

/* 
    The purpose of this page is to simply determine if the user has multiple roles. 
    If they do, provide them the option to go where they want to go. 
    Else, redirect to the only place they can go.
*/

$iniContents = parse_ini_file("../properties/config.ini", true); //Gather from config.ini file
$connectionsFileLocation = $_SERVER["DOCUMENT_ROOT"]."/openCad/".$iniContents['main']['connection_file_location'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require($connectionsFileLocation);

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$link) {
    die('Could not connect: ' .mysql_error());
}

$id = $_SESSION['id'];
$sql = "SELECT * from user_departments WHERE user_id = \"$id\"";

$result=mysqli_query($link, $sql);

$adminButton = "";
$dispatchButton = "";
$highwayButton = "";
$fireButton = "";
$emsButton = "";
$sheriffButton = "";
$policeButton = "";
$civilianButton = "";

$num_rows = $result->num_rows;
// This loop will auto redirect the user if they only have one option 
// TODO: Add the rest of the headers
if($num_rows < 2)
{
    while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        if ($row[1] == "0")
        {
            $_SESSION['admin'] = 'YES';
            header("Location:../administration/admin.php");
            
        }
        else if ($row[1] == "1")
        {
            $_SESSION['dispatch'] = 'YES';
            header("Location:../dispatch/dispatch.php"); 
            
        }
        else if ($row[1] == "2")
        {
            header("Location:../responder/responder.php"); 
        }
        else if ($row[1] == "3")
        {
            header("Location:../responder/responder.php"); 
        }
        else if ($row[1] == "4")
        {
            header("Location:../responder/responder.php"); 
        }
        else if ($row[1] == "5")
        {
            header("Location:../responder/responder.php"); 
        }
        else if ($row[1] == "6")
        {
            header("Location:../responder/responder.php"); 
        }
        else if ($row[1] == "7")
        {
            header("Location:../civilian/civilian.php"); 
        }
        
    }
}
else
{

    while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        if ($row[1] == 0)
        { 
            $adminButton = "<a href=\"../administration/admin.php\" class=\"btn btn-primary btn-lg\">Administration</a>";
            $_SESSION['admin'] = 'YES';
        }
        if ($row[1] == 1)
        {
            $_SESSION['dispatch'] = 'YES';
            $dispatchButton = "<a href=\"../dispatch/dispatch.php\" class=\"btn btn-primary btn-lg\">Dispatch</a>";
        }
        if ($row[1] == "2")
        {
            $emsButton = "<a href=\"../responder/responder.php\" class=\"btn btn-primary btn-lg\">EMS</a>";
        }
        if ($row[1] == "3")
        {
            $fireButton = "<a href=\"../responder/responder.php?fire=true\" class=\"btn btn-primary btn-lg\">Fire Department</a>";
        }
        if ($row[1] == "4")
        {
            $highwayButton = "<a href=\"../responder/responder.php\" class=\"btn btn-primary btn-lg\">Highway Patrol</a>";
        }
        if ($row[1] == "5")
        {
            $policeButton = "<a href=\"../responder/responder.php\" class=\"btn btn-primary btn-lg\">Police Department</a>";
        }
        if ($row[1] == "6")
        {
            $sheriffButton = "<a href=\"../responder/responder.php\" class=\"btn btn-primary btn-lg\">Sheriff's Office</a>";
        }
        if ($row[1] == "7")
        { 
            $civilianButton = "<a href=\"../civilian/civilian.php\" class=\"btn btn-primary btn-lg\">Civilian</a>";
        }
    }
}
mysqli_close($link);


?>

<html lang="en">
<!DOCTYPE html>
<head>
    <!-- CSS -->
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
    #cadWelcome {
    height:20px; 
    width:50px; 
    margin: 50%px 50%px; 
    position:relative;
    top:90%; 
    left:45%;
    text-align:center;
    }
    </style>
    <title>CAD/MDT Launcher</title>
    <link rel="icon" href="../images/favicon.ico" />
</head>
<body>
   <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="text-align:center;">Select console to launch:</h1>
                </div>
                <!-- ./ col-lg-12 -->
            </div>
            <!-- ./ row -->
            </div class="row">
                <div class="col-lg-12" id="cadWelcome">
                    <?php echo $adminButton;?><br/><br/>
                    
                    <?php echo $dispatchButton;?>
                    &nbsp;
                    <?php echo $emsButton;?>
                    &nbsp;
                    <?php echo $fireButton;?>
                    &nbsp;
                    <?php echo $highwayButton;?>
                    &nbsp;
                    <?php echo $policeButton;?>
                    &nbsp;
                    <?php echo $sheriffButton;?>
                    &nbsp;
                    <?php echo $civilianButton;?>
                </div>
                <!-- ./ col-lg-12 -->
            </div>
            <!-- ./ row -->
        </div>
        <!-- ./ container-fluid -->
    </div>
    <!-- ./ page-wrapper -->
</body>
</html>
