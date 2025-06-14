<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    /* footer */
  .footer {
    background: linear-gradient(to right, #1f1f1f, #2c3e50);
    color: #f1f1f1;
    text-align: center;
    padding: 2rem 1rem;
    font-size: 0.9rem;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.2);
    /* margin-top: 4rem; */
  }

  .footer-container {
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .footer-container a {
    color: #00d1b2;
    text-decoration: none;
    margin: 0 6px;
    transition: color 0.3s ease;
  }

  .footer-container a:hover {
    color: #4CAF50;
  }

  .footer-container i {
    font-size: 1.2rem;
    vertical-align: middle;
    margin: 0 6px;
    color: #00d1b2;
    transition: color 0.3s ease;
    text-shadow: 0 0 4px rgba(0, 209, 178, 0.5);
  }

  .footer-container i:hover {
    color: #4CAF50;
  }

</style>
<body>
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
</body>
</html>