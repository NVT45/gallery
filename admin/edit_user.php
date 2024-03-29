<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>
<?php 

if(!$session->is_signed_in()) { redirect("login.php");}

 ?>
<?php 
if(empty($_GET['id'])){
    redirect("users.php");
 }else{
  $user = User::find_by_id($_GET['id']);
if(isset($_POST['update'])){
  if($user){
    $user->username = $_POST['username'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->password = $_POST['password'];
    if(empty($_FILES['user_image'])){
      $user->save();
      redirect("users.php");
      $session->message("The user has been update");
    }
    else{
      $user->set_file($_FILES['user_image']);
      $user->save_user_and_image();
      $user->save();
      $session->message("The user has been update");
      redirect("users.php");
      // redirect("edit_user.php?id={$user->id}");

    }
    
  }
}
}
 ?>



        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->

                <?php include("includes/top_nav.php"); ?>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            
                <?php include("includes/side_nav.php"); ?>

                

            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

             <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Edit 
                            <small>Subheading</small>
                        </h1>

                        <div class="col-md-6 user_image_box">
                         <a href="#" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $user->image_path_and_placeholder()  ?>" alt=""></a> 
                        </div>
                        <div class="col-md-6">
                            <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-control">
                            <input type="file" name="user_image">
        
                         </div> 
                        <div class="form-group">
                            <label for="username" > Username </label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo $user->username; ?>"  >  
                        </div>
                        <div class="form-group">
                            <label for="first name"> First Name </label>
                            <input type="text" id="first name" name="first_name" class="form-control" value="<?php echo $user->first_name; ?> " >  
                        </div>
                        <div class="form-group">
                            <label for="last name"> Last Name </label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?> " >  
                        </div>
                        <div class="form-group">
                            <label for="password"> Password </label>
                            <input type="password" name="password" class="form-control"  value="<?php echo $user->password; ?>">  
                        </div>
                        <div class="form-group">
                            <a id="user_id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id ?>">Delete</a>
                            <input type="submit" name="update" class="btn btn-primary" value="Update" >  
                        </div>
                            </form>
                        
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
           

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>