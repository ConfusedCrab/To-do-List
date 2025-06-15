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
    $userId = $_SESSION['user_id'];

    // checks the boxes are not blank
    if (empty($title) || empty($description)) {
        $error = "Please fill in all fields before submitting.";
    } else {

        //  inserting the data 
        // $sql = "INSERT INTO notes (`Title`, `Description`) VALUES('$title', '$description')";
        $sql = "INSERT INTO notes (`user_id`,`Title`, `Description` ) VALUES('$userId', '$title', '$description' )";
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
<link rel="icon" href="../asset/favicon.ico">

     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css">

    <!-- for table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
</head>

<body>

    <!-- adding header -->
    <?php include '../partials/header.php'; ?>

    <main>
        <!-- greeting the user and showing the name  -->
        <section class="todo-app app-header">
            <?php
            if ($loggedin) {
                $username = $_SESSION['username'];
                echo "<h1>Welcome, $username </h1>";
                echo "<p>Write it down, before your brain yeets it away.</p>";
            } else {
                echo "<h1>Welcome, Guest!</h1>";
                echo ' <p><a href="#" id="loginBtn" data-bs-toggle="modal" data-bs-target="#LoginModal">Login </a>to Add a Task</p>';
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

                <?php
                $loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
                ?>

                <form class="input-section" id="noteForm" action="index.php" method="post"
                    data-loggedin="<?= $loggedin ? '1' : '0' ?>">
                    <input type="text" class="task-input" name="title" id="title" placeholder="Add a new task..."
                        required>

                    <div class="input-section" style="margin-bottom: 2rem;">
                        <textarea class="task-input" name="description" id="description" placeholder="Task Description"
                            rows="3" required></textarea>
                    </div>

                    <?php if ($loggedin): ?>
                        <button type="submit" class="add-btn" onclick="submitNote()">Add Note</button>
                    <?php else: ?>
                        <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#LoginModal">
                            Login to Add Note
                        </button>
                    <?php endif; ?>
                </form>

                <!-- <div class="filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="active">Active</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
             </div> -->

                <div class="CustomTable task-list table-responsive-custom">
                    <table class="CustomTable nowrap" id="myTable" style="width:100%">
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
                            // $sql = "SELECT * FROM `notes`";
                            
                            if (isset($_SESSION['user_id'])) {
                                $userId = intval($_SESSION['user_id']); // Always sanitize!
                                $sql = "SELECT * FROM `notes` WHERE `user_id` = $userId";
                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    echo "<tr><td colspan='4'>Error retrieving notes: " . mysqli_error($conn) . "</td></tr>";
                                } else {
                                    $counter = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                <tr>
                                  <td scope='row'> " . $counter++ . "</td>
                                    <td>" . $row['Title'] . "</td>
                                     <td>" . $row['Description'] . "</td>
                                       <td>
                                       
                                
                                           <button class='edit btn-primary' data-id='" . $row['S_no'] . "' data-title=\"" . htmlspecialchars($row['Title'], ENT_QUOTES) . "\" data-description=\"" . htmlspecialchars($row['Description'], ENT_QUOTES) . "\">
                                                     Edit
                                                   </button>

                                      
                                           <a href='../partials/delete.php?id=" . $row['S_no'] . "' onclick='return confirm(\"Are you sure?\")' class='table-button'>Delete</a>    
                                      </td>

                                </tr>";
                                    }
                                }
                             }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- adding about section -->
        <?php include '../partials/about.php'; ?>

        <!-- adding contact_us section -->
        <?php include '../partials/contact_us.php'; ?>


        <!-- <div class="offline-badge">
        <i class="fas fa-wifi-slash"></i> You're offline
    </div> -->
    </main>

    <!-- adding footer -->
    <?php include '../partials/footer.php'; ?>

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
    <!-- for input form  -->
    <script>
        document.getElementById('noteForm').addEventListener('submit', function (event) {
            const isLoggedIn = this.dataset.loggedin === "1";
            if (!isLoggedIn) {
                event.preventDefault(); // Block form submission
                const loginModal = new bootstrap.Modal(document.getElementById('LoginModal'));
                loginModal.show(); // Show login modal
            }
        });
        
    </script>


</body>

</html>