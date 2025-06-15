<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
    
<style>
  /* Navbar Styles */
.custom-navbar {
    background: linear-gradient(to right, #1f1f1f, #2c3e50);
    color: white;
    padding: 2rem 2rem;
    /* ← this controls the height */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    /* softer, modern shadow */
    position: fixed;
    top: 0;
    z-index: 1000;
    width: 100%;
    margin-right: 40px;
  }
  
/* Flex container for nav content */
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
  text-decoration: none;
}

/* Menu */
.nav-links {
    list-style: none;
    display: flex;
    gap: 2rem;
}

.nav-links li a {
  color: white;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
    position: relative;
  }
  
  /* Underline hover effect */
  .nav-links li a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: white;
    transition: all 0.3s ease;
  }
  
  .nav-links li a:hover::after {
    width: 100%;
  }
  
  /* Center the <p> block horizontally */
  /* User buttons */
  .btn-3d {
    display: flex;
    justify-content: center;
    gap: 1rem; /* add spacing between buttons */
  }
  
  
  /* Style the link inside */
  .btn-3d a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    margin-right: 5px;
    background-color: rgb(0, 209, 108);
    border: none;
    box-shadow: 0 6px 0 #088178;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    outline: none;
  }
  
.btn-3d a:hover {
  background-color: #4CAF50;
  transform: translateY(-2px);
  box-shadow: 0 8px 0 #088178;
  color: white;
}

.btn-3d a:focus {
  /* outline: 3px solid #93c5fd; Light blue outline for visibility */
  outline-offset: 3px;
}

.btn-3d a:active {
  transform: translateY(6px);
  box-shadow: none;
  background-color: #00b3a4;
}

.burger.toggle .line1 {
  transform: rotate(-45deg) translate(-5px, 6px);
}

.burger.toggle .line2 {
  opacity: 0;
}

.burger.toggle .line3 {
  transform: rotate(45deg) translate(-5px, -6px);
}



/* Responsive Design */
/* navbar */
@media (max-width: 768px) {
  .nav-links {
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
      
      .nav-links.active {
        right: 0;
        background: linear-gradient(to right, #1f1f1f, #2c3e50);

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
      
      /* Hide 3D button on mobile, show burger button */
      .loginBtn {
        display: none !important;
      }
      
      .loginBtnMobile {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        color: white;
        border-radius: 5px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
      }

      .loginBtnMobile:hover {
        background-color: darkred;
        transform: scale(1.05);
      }
}
</style>

</head>
<body>
  <header>
    <nav class="custom-navbar">
      <div class="navbar-container">
                <div class="navbar-logo"><a href="#home">Todo</a></div>

                <!-- Links -->
                <ul class="nav-links" id="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <?php if (!$loggedin): ?>
                    <li class="d-md-none">
                      <a href="#" class="loginBtn-mobile" data-bs-toggle="modal" data-bs-target="#Sign_upModal">Sign up</a>
                          </li>
                    <li class="d-md-none">
                      <a href="#" class="loginBtn-mobile" data-bs-toggle="modal"
                            data-bs-target="#LoginModal">Login</a>
                          </li>
                    <?php else: ?>
                    <li class="d-md-none">
                      <a href="logout.php" class="loginBtn-mobile">Logout</a>
                    </li>
                    <?php endif; ?>


                </ul>

                <?php
        if (!$loggedin) {
          echo ' <p class="btn-3d">
                    <a href="#" class="loginBtn"  data-bs-toggle="modal" data-bs-target="#Sign_upModal">
                        <i class="hgi hgi-stroke hgi-user-circle-02"></i>
                        Sign up
                    </a>
                    <a href="#" class="loginBtn" data-bs-toggle="modal" data-bs-target="#LoginModal">
                        Login
                    </a>
                </p>';
        }
        if ($loggedin) {
          echo '
                          <p class="btn-3d">
                          <a href="logout.php" class="loginBtn">
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

    <!-- for burger -->
    <script>
    // Mobile Navigation
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        nav.classList.toggle('active');
        burger.classList.toggle('toggle');
    });

    // Close mobile menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('active');
            burger.classList.remove('toggle');
        });
    });

    // Function to close the mobile nav
    function closeSidebar() {
        nav.classList.remove('active');
        burger.classList.remove('toggle');
    }

    // Close sidebar when clicking outside of it
    document.addEventListener('click', function(event) {
        const isClickInsideNav = event.target.closest('.nav-links');
        const isClickOnBurger = event.target.closest('.burger');

        if (!isClickInsideNav && !isClickOnBurger) {
            closeSidebar();
        }
    });
    </script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>