<?php include "includes/admin_header.php"?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_nav.php"?>

        <div id="page-wrapper">
            <div class="container-fluid">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>In Response to</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Unapprove</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $comment_post_id = mysqli_real_escape_string($connection, $_GET['id']);
                    $query = "SELECT * FROM comments WHERE comment_post_id = '$comment_post_id'";
                    $select_comments = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_comments)) {
                        $comment_id = $row['comment_id'];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_email = $row['comment_email'];
                        $comment_content = $row['comment_content'];
                        $comment_status = $row['comment_status'];
                        $comment_date = $row['comment_date'];

                        echo "<tr>";
                        echo "<td>$comment_id</td>";
                        echo "<td>$comment_author</td>";
                        echo "<td>$comment_content</td>"; 

                        echo "<td>$comment_email</td>";
                        echo "<td>$comment_status</td>";

                        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                        $select_post_id_query = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($select_post_id_query)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];

                            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                        }     
                        
                        echo "<td>$comment_date</td>";
                        echo "<td><a href='post_comment.php?approve=$comment_id'>Approve</a></td>";
                        echo "<td><a href='post_comment.php?unapprove=$comment_id'>Unapprove</a></td>";
                        echo "<td><a href='post_comment.php?delete=$comment_id'>Delete</a></td>";
                        echo "</tr>";
                    }

                ?>

                </tbody>
            </table>

                <?php
                if(isset($_GET['approve'])) {
                    $the_comment_id = $_GET['approve'];

                    $unapprove_comment_query = "UPDATE comments 
                            SET comment_status = 'approve'
                            WHERE comment_id = $the_comment_id";
                    
                    $unapprove_comment_query = mysqli_query($connection, $unapprove_comment_query);
                    header("Location: comments.php");
                }

                if(isset($_GET['unapprove'])) {
                    $the_comment_id = $_GET['unapprove'];

                    $unapprove_comment_query = "UPDATE comments 
                            SET comment_status = 'unapprove'
                            WHERE comment_id = $the_comment_id";
                    
                    $unapprove_comment_query = mysqli_query($connection, $unapprove_comment_query);
                    header("Location: comments.php");
                }

                if(isset($_GET['delete'])) {
                    $the_comment_id = $_GET['delete'];
                    $query = "DELETE FROM comments WHERE comment_id = $the_comment_id";
                    $delete_query = mysqli_query($connection, $query);
                    header("Location: comments.php");
                }
                ?>

            </div>
            <!-- /.container-fluid -->            
        </div>
        <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php"?>