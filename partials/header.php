<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
      /* Navbar Styles */
  .custom-navbar {
    background: linear-gradient(to right, #1f1f1f, #2c3e50);
    color: white;
    padding: 2rem 2rem;
    /* ← this controls the height */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    position: fixed;
    top: 0;
    z-index: 1000;
    width: 100%;
    margin-right: 40px;
  }

  .navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  /* Brand */
  .navbar-logo a {
    font-size: 1.8rem;
    font-weight: bold;
    color: #00d1b2;
    justify-content: space-between;
    text-decoration: none;
  }

  /* Menu */
  .navbar-menu {
    list-style: none;
    display: flex;
    gap: 2rem;
  }

  .navbar-menu li a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
  }

  .navbar-menu li a:hover {
    color: #00d1b2;
  }

  /* Center the <p> block horizontally */
  #user {
    text-align: center;
  }

  /* Style the link inside */
  #user a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
    padding: 0.5rem 1rem;
    border: 1px solid white;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    margin-right: 5px;
  }

  #user a:hover {
    color: #00d1b2;
    background-color: white;
    border-color: #00d1b2;
  }


  @media (max-width: 915px) {
    .navbar-menu {
      position: fixed;
      top: 0;
      right: -100%;
      width: 70%;
      height: 100vh;
      background-color: white;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: 0.3s;
    }

    .navbar-menu.active {
      right: 0;
    }

    .burger {
      display: block;
      cursor: pointer;
    }

    .burger div {
      width: 25px;
      height: 3px;
      background-color: white;
      margin: 5px;
      transition: 0.3s;
    }
  }

</style>
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

</body>
</html>