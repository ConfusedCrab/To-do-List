<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    /* contact-us section  */
  .contact-section {
    padding: 4rem 1rem;
    background: linear-gradient(to right, #2c3e50, #1f1f1f);
    color: white;
  }

  .contact-container {
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 2rem;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
  }

  .contact-container h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #00d1b2;
  }

  .contact-container p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 2rem;
  }

  .contact-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .contact-form input,
  .contact-form textarea {
    padding: 1rem;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 1rem;
  }

  .contact-form input::placeholder,
  .contact-form textarea::placeholder {
    color: rgba(255, 255, 255, 0.6);
  }

  .contact-btn {
    background-color: #00d1b2;
    border: none;
    color: white;
    padding: 0.75rem;
    font-size: 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  .contact-btn:hover {
    background-color: #4CAF50;
    transform: translateY(-2px);
  }

</style>
<body>
            <section class="contact-section" id="contact">
            <div class="contact-container">
                <h2>Contact Us</h2>
                <p>Have a question, suggestion, or just want to say hi? Drop a message below.</p>

                <form class="contact-form">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    <button type="submit" class="contact-btn">Send Message</button>
                </form>
            </div>
        </section>

</body>
</html>