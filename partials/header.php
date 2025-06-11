<?php
session_start();
$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $loggedin && isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
 <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding-top: 80px;
      }


  /* Navbar Styles */
  .custom-navbar {
      background: linear-gradient(to right, #1f1f1f, #2c3e50);
      color: white;
      padding: 1rem 2rem;
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


  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    padding: 2rem;
    width: 90%;
    max-width: 400px;
    border-radius: 12px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-tabs {
    display: flex;
    margin: 1rem 0;
}

.tab-btn {
    flex: 1;
    padding: 0.5rem;
    border: none;
    cursor: pointer;
    background: #f0f0f0;
    font-weight: bold;
}

.tab-btn.active {
    background: #007BFF;
    color: white;
}

.modal-footer {
    text-align: right;
}

.modal-content input {
    display: block;
    width: 100%;
    margin: 0.5rem 0;
    padding: 0.6rem;
    font-size: 1rem;
}

</style>
</head>

<body>
  <header>
    <nav class="custom-navbar">
      <div class="navbar-container">
        <div class="navbar-logo"><a href="#home">Todo</a></div>

        <ul class="navbar-menu" id="navMenu">
          <li><a href="../login-session">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ul>

        <div id="user">
          <?php if ($loggedin): ?>
            <a href="../login-system/log_out.php">Hi, <?= $username ?> | Log Out</a>
          <?php else: ?>
            <a href="#" id="loginBtn">Sign up/Log in</a>
          <?php endif; ?>
        </div>

        <div class="burger" id="burger">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Auth Modal
  <div id="authModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 id="authModalTitle">Login</h2>
        <span class="close-btn" id="closeAuthModalBtn">&times;</span>
      </div>

      <div class="modal-tabs">
        <button id="loginTab" class="tab-btn active">Login</button>
        <button id="signupTab" class="tab-btn">Sign Up</button>
      </div>

      <form method="POST" action="../login-session/auth.php" id="authForm">
        <input type="hidden" name="action" id="authAction" value="login">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <div id="signupFields" style="display: none;">
          <input type="email" name="email" placeholder="Email">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div> -->
<!-- Auth Modal -->
<div id="authModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 id="authModalTitle">Login</h2>
      <span class="close-btn" id="closeAuthModalBtn">&times;</span>
    </div>

    <div class="modal-tabs">
      <button id="loginTab" class="tab-btn active">Login</button>
      <button id="signupTab" class="tab-btn">Sign Up</button>
    </div>

    <form method="POST" action="../login-session/auth.php" id="authForm">
      <input type="hidden" name="action" id="authAction" value="login">

      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>

      <div id="signupFields" style="display: none;">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="cpassword" placeholder="Confirm Password">
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>

  <!-- JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const authModal = document.getElementById('authModal');
      const loginBtn = document.getElementById('loginBtn');
      const closeAuthModalBtn = document.getElementById('closeAuthModalBtn');
      const loginTab = document.getElementById('loginTab');
      const signupTab = document.getElementById('signupTab');
      const authTitle = document.getElementById('authModalTitle');
      const authAction = document.getElementById('authAction');
      const signupFields = document.getElementById('signupFields');

      if (loginBtn) {
        loginBtn.onclick = () => {
          authModal.style.display = 'flex';
        };
      }

      closeAuthModalBtn.onclick = () => {
        authModal.style.display = 'none';
      };

      window.onclick = (e) => {
        if (e.target === authModal) authModal.style.display = 'none';
      };

      loginTab.onclick = () => {
        loginTab.classList.add('active');
        signupTab.classList.remove('active');
        authTitle.textContent = 'Login';
        authAction.value = 'login';
        signupFields.style.display = 'none';
      };

      signupTab.onclick = () => {
        signupTab.classList.add('active');
        loginTab.classList.remove('active');
        authTitle.textContent = 'Sign Up';
        authAction.value = 'signup';
        signupFields.style.display = 'block';
      };
    });

    // auth-modal.js
document.getElementById("loginTab").addEventListener("click", function () {
  document.getElementById("authModalTitle").textContent = "Login";
  document.getElementById("authAction").value = "login";
  document.getElementById("signupFields").style.display = "none";
});

document.getElementById("signupTab").addEventListener("click", function () {
  document.getElementById("authModalTitle").textContent = "Sign Up";
  document.getElementById("authAction").value = "signup";
  document.getElementById("signupFields").style.display = "block";
});

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>
