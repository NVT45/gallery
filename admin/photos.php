<?php include("includes/header.php"); ?>

<?php 

if(!$session->is_signed_in()) { redirect("login.php");}

 ?>

 <?php 

$photos = Photo::find_all();

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
                           Photos
                            <small>Subheading</small>
                        </h1>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>ID</th>
                                        <th>Filename</th>
                                        <th>Title</th>
                                        <th>Size</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($photos as $photo) : ?>
                                         
                                    <tr>
                                        <td><img width="150px" src="<?php echo $photo->picture_path() ?>" alt=""></td>
                                        <td><?php echo $photo->photo_id; ?></td>
                                        <td><?php echo $photo->filename; ?></td>
                                        <td><?php echo $photo->title; ?></td>
                                        <td><?php echo $photo->size; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
           

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>