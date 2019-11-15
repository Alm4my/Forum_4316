<?php
session_start();
$msg_title = "Welcome to the International University of Grand-Bassam's
              Student Government Association forum.";
$msg_sub = "This is a platform where student can exchange
            about their issues and together find solutions.";
// Check if user is already logged in if not redirects you to log in page
//if (!isset($_SESSION['user_name'])) {
//    $_SESSION['msg'] = "You must log in first";
//    header('location: login.php');
//}
//if (isset($_GET['logout'])) {
//    session_destroy();
//    unset($_SESSION['user_name']);
//    header("location: login.php");
//}
include 'header.php';

?>
            <button class="dropdown button radius" type="button" data-toggle="sorting">
                Latest
            </button>
            <div class="dropdown-pane" id="sorting" data-dropdown>
                <ul id="sort-dropdown" data-dropdown-men>
                    <li><a href="#"><i class="check fa fa-check"></i> Latest </a></li>
                    <li><a href="#"><i></i> Top </a></li>
                    <li><a href="#"> Newest </a></li>
                    <li><a href="#"> Oldest </a></li>
                </ul>
            </div>
            <div class="questions">
                <div id="question1">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="#">
                            Why isn't 1 lunch 2 breakfasts?
                        </a>
                        <br>
                        <span class="user">
                            <b>Rulis12</b> started 2 hours ago
                        </span>
                    </p>
                </div>
                <div id="question2">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="#">
                            Where is our midterm break for the spring semester?
                        </a>
                        <br>
                        <span class="user">
                            <b>DominiqueDeh</b> started 2 days ago
                        </span>
                    </p>
                </div>
                <div id="question3">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="#">
                            Are we going to do something about our cafeteria meal?
                        </a>
                        <br>
                        <span class="user">
                            <b>AchiCedric</b> started 7 days ago
                        </span>
                    </p>
                </div>
                <div id="question4">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="">
                         What is the hardest class you have ever taken?
                        </a>
                        <br>
                        <span class="user">
                            <b>AlmamyCLB</b> started 12 days ago
                        </span>
                    </p>
                </div>
                <div id="question5">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="#">
                            How can we do the square root using division?
                        </a>
                        <br>
                        <span class="user">
                            <b>Geek225</b> started 13 days ago
                        </span>
                    </p>
                </div>
                <div id="question6">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="">
                            Who knows some alumni?
                        </a>
                        <br>
                        <span class="user">
                            <b>Ronald.D</b> started 14 days ago
                        </span>
                    </p>
                </div>
                <div id="question7">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="">
                            Fun stuff to do in Bassam?
                        </a>
                        <br>
                        <span class="user">
                            <b>ClassNerd</b> started 14 days ago
                        </span>
                    </p>
                </div>
                <div id="question5">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="#">
                            Looking for advanced CSC majors!!!
                        </a>
                        <br>
                        <span class="user">
                            <b>Mikasa225</b> started 15 days ago
                        </span>
                    </p>
                </div>
                <div id="question6">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="">
                            How to pick majors?
                        </a>
                        <br>
                        <span class="user">
                            <b>Ronald.D</b> started 15 days ago
                        </span>
                    </p>
                </div>
                <div id="question7">
                    <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                    <p>
                        <a href="funact">
                            /!\ End of semester activities XD!!!
                        </a>
                        <br>
                        <span class="user">
                            <b>ClassNerd</b> started 1 month ago
                        </span>
                    </p>
                </div>
            </div>
<?php include 'footer.php'; ?>