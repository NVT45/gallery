<div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>
                       <?php 
                           

                           
                            // $result_set = User::find_all_users(); nếu đã khai báo static
                            // while ($row = mysqli_fetch_array($result_set)) {
                            //     echo $row['username'];
                            // }


                            // $found_user = User::find_user_by_id(1);

                            // $user = User::instantation($found_user);
                            // echo $user->password;


                            // $users = User::find_all_users();

                            // foreach ($users as $user) {
                            //     echo $user->id;
                            // }

                            // $found_user = User::find_user_by_id(1);

                            // echo $found_user->username;

                            $user = new User();

                            $user -> username = "Iron";
                            $user -> password = "i123456";
                            $user -> first_name = "Iron";
                            $user -> last_name = "Man";
                            $user->create();

                            


                        ?>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>