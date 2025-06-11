<!-- 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login-session/login.php"); 
    exit;
}
$userId = $_SESSION['user_id']; -->

<?php
session_start();
?>


<?php

//database connection
include '../partials/database.php';

// free variables
$insert = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];


    // checks the boxes are not blank
    if (empty($title) || empty($description)) {
        $error = "Please fill in all fields before submitting.";
    } else {

        //  inserting the data 
        // $sql = "INSERT INTO notes (`Title`, `Description`, `user_id`) VALUES('$title', '$description', '$userId')";
        $sql = "INSERT INTO notes (`Title`, `Description`) VALUES('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            $error = "Database error. Please try again.";
        }
    }
}


$statusMessage = '';
$statusType = '';

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'updated':
            $statusMessage = 'Note updated successfully!';
            $statusType = 'success';
            break;
        case 'deleted':
            $statusMessage = 'Note deleted successfully!';
            $statusType = 'success';
            break;
        case 'error':
            $statusMessage = 'Something went wrong.';
            $statusType = 'error';
            break;
        case 'account_created':
            $statusMessage = 'Account created successfully!';
            $statusType = 'success';
            break;
        case 'signup_error':
            $statusMessage = $_GET['message'] ?? 'Sign-up failed.';
            $statusType = 'error';
            break;
        case 'login_success':
            $statusMessage = 'Login successful!';
            $statusType = 'success';
            break;
        case 'logerror':
            $statusMessage = $_GET['msg'] ?? "Can't login.";
            $statusType = 'error';
            break;
    }
}
?>

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css">

    <!-- for table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">

    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

</head>

<body>
    <header>
        <nav class="custom-navbar">
            <div class="navbar-container">
                <div class="navbar-logo"><a href="#home">Todo</a></div>

                <!-- Links -->
                <ul class="navbar-menu" id="navMenu">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>

                <?php
                if (!$loggedin) {
                    echo ' <p id="user">
                    <a href="#" id="loginBtn" data-bs-toggle="modal" data-bs-target="#Sign_upModal">
                        <i class="hgi hgi-stroke hgi-user-circle-02"></i>
                        Sign up
                    </a>
                    <a href="#" id="loginBtn" data-bs-toggle="modal" data-bs-target="#LoginModal">
                        Login
                    </a>
                </p>';
                }
                if ($loggedin) {
                    echo '
                          <p id="user">
                          <a href="logout.php">
                         <i class="hgi hgi-stroke hgi-user-circle-02"></i>
                          Logout
                           </a>
                            </p>';
                }


                ?>
                <!-- Hamburger Icon -->
                <div class="burger" id="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- greeting the user and showing the name  -->
        <section class="todo-app app-header">
            <?php
            if ($loggedin) {
                $username = $_SESSION['username'];
                echo "<h1>Welcome, $username </h1>";
                echo "<p>Write it down, before your brain yeets it away.</p>";
            }
            ?>
        </section>

        <section class="container" id="home">
            <div class="todo-app">
                <div class="app-header">
                    <h1>TaskMaster</h1>
                    <p>Organize your day with style</p>
                    <!-- <h1>Add Note</h1>
                        <p>Write it down, before your brain yeets it away.</p> -->
                </div>

                <form class="input-section" id="noteForm" action="index.php" method="post">
                    <input type="text" class="task-input" name="title" id="title" placeholder="Add a new task..."
                        required>


                    <div class="input-section" style="margin-bottom: 2rem;">
                        <textarea class="task-input" name="description" id="description" placeholder="Task Description"
                            rows="3" required></textarea>
                    </div>

                    <button type="submit" class="add-btn" onclick="submitNote()">Add Note</button>
                </form>

                <!-- <div class="filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="active">Active</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
            </div> -->

                <div class="table task-list">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.no.</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            //displaying data
                            // $sql = "SELECT * FROM `notes` WHERE user_id = $userId";
                            $sql = "SELECT * FROM `notes`";

                            $result = mysqli_query($conn, $sql);

                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <tr>
                                  <th scope='row'>" . $counter++ . "</th>
                                    <td>" . $row['Title'] . "</td>
                                     <td>" . $row['Description'] . "</td>
                                       <td>
                                       
                                        <button 
                                          class='edit btn-primary' 
                                            data-id='" . $row['S_no'] . "' 
                                              data-title=\"" . htmlspecialchars($row['Title'], ENT_QUOTES) . "\" 
                                              data-description=\"" . htmlspecialchars($row['Description'], ENT_QUOTES) . "\">
                                                     Edit
                                                   </button>
                                         
                                           <a href='../partials/delete.php?id=" . $row['S_no'] . "' onclick='return confirm(\"Are you sure?\")' class='table-button'>Delete</a>    
                                      </td>

                                </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="about-section" id="about">
            <h2>About TaskMaster</h2>
            <p>
                TaskMaster is your minimalist companion for conquering chaos — a sleek, no-nonsense Todo app built to
                help you
                organize your day and reclaim your focus. Whether it's college deadlines, work tasks, or just
                remembering to
                water that sad-looking plant, TaskMaster's got your back.
            </p>
            <p>
                TaskMaster was designed and developed by Garvit as part of an initiative to deepen full-stack
                development
                skills.
                It reflects a strong focus on usability, maintainability, and aesthetic simplicity — turning a basic
                to-do app into a
                streamlined productivity tool.
            </p>

            <p>
                Got feedback? Want to collab? Hit me up through the Contact section!
            </p>
        </section>



        <section class="contact-section" id="contact">
            <div class="contact-container">
                <h2>Contact Us</h2>
                <p>Have a question, suggestion, or just want to say hi? Drop a message below.</p>

                <form class="contact-form" action="mailto:youremail@example.com" method="POST" enctype="text/plain">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    <button type="submit" class="contact-btn">Send Message</button>
                </form>
            </div>
        </section>

        <!-- <div class="offline-badge">
            <i class="fas fa-wifi-slash"></i> You're offline
        </div> -->
    </main>


    <footer class="footer">
        <div class="footer-container">
            <p>&copy; 2025 TaskMaster. All rights reserved.</p>
            <p>Developed by Garvit | <a href="#home">Home</a> | <a href="#about">About</a> | <a href="#contact">Contact
                    Us</a></p>
            <p>
                Follow me:
                <a href="https://github.com/ConfusedCrab" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-github"></i>
                </a>
                <a href="https://leetcode.com/u/ConfusedCrab/" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-linkedin"></i>
                </a>

            </p>

        </div>
    </footer>

    <!-- Custom Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Note</h2>
                <span class="close-btn" id="closeModalBtn">&times;</span>
            </div>
            <form method="POST" action="../partials/update.php" id="editForm">
                <div class="modal-body">
                    <input type="hidden" name="s_no" id="editSno">
                    <input type="text" name="title" id="editTitle" placeholder="Title" required>
                    <textarea name="description" id="editDescription" placeholder="Description" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" id="cancelEdit">Cancel</button>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Sign Up Modal -->
    <div class="modal fade" id="Sign_upModal" tabindex="-1" aria-labelledby="ModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content mx-auto" style="max-width: 500px;">
                <!-- Center horizontally -->

                <div class="modal-header">
                    <h2 class="modal-title" id="ModalTitle">Sign up</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="closeAuthModalBtn"></button>
                </div>

                <form method="POST" action="sign_up.php" id="signForm">
                    <div class="modal-body">
                        <input type="text" name="username" placeholder="Username" required class="form-control mb-2">
                        <input type="password" name="password" placeholder="Password" required
                            class="form-control mb-2">
                        <input type="password" name="cpassword" placeholder="Confirm Password" required
                            class="form-control mb-2">
                        <input type="email" name="email" placeholder="Email" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="ModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content mx-auto" style="max-width: 500px;">
                <!-- Center horizontally -->

                <div class="modal-header">
                    <h2 class="modal-title" id="ModalTitle">Login</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="closeAuthModalBtn"></button>
                </div>

                <form method="POST" action="login.php" id="LoginForm">
                    <div class="modal-body">
                        <input type="text" name="username" placeholder="Username" required class="form-control mb-2">
                        <input type="password" name="password" placeholder="Password" required
                            class="form-control mb-2">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- script for table  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
        </script>

    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>

    <script>
        // notification
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // From PHP flags
        <?php if ($insert): ?>
            showNotification("Note added successfully!", "success");
        <?php elseif ($error): ?>
            showNotification("<?= $error ?>", "error");
        <?php endif; ?>

        // From GET status
        <?php if (!empty($statusMessage)): ?>
            showNotification("<?= $statusMessage ?>", "<?= $statusType ?>");
        <?php endif; ?>
    </script>

    <!-- for burger -->
    <script>
        const burger = document.getElementById('burger');
        const navMenu = document.getElementById('navMenu');

        burger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            burger.classList.toggle('toggle');
        });
    </script>

    <!-- modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('editModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelEditBtn = document.getElementById('cancelEdit');

            document.querySelectorAll('.edit').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const description = this.getAttribute('data-description');

                    document.getElementById('editSno').value = id;
                    document.getElementById('editTitle').value = title;
                    document.getElementById('editDescription').value = description;

                    modal.style.display =
                        'flex'; // or use Bootstrap’s `show` class if you’re using Bootstrap modals
                });
            });

            closeModalBtn.onclick = () => modal.style.display = 'none';
            cancelEditBtn.onclick = () => modal.style.display = 'none';

            window.onclick = (e) => {
                if (e.target == modal) modal.style.display = 'none';
            };
        });
    </script>

    <!-- sign up modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('Sign_upModal');
            const bsModal = new bootstrap.Modal(modalElement); // optional, only if you want to open/close via JS

            // Optional: Hook into close button
            document.getElementById('closeAuthModalBtn').addEventListener('click', function () {
                bsModal.hide(); // this is the Bootstrap way
            });

        });
    </script>


</body>

</html>