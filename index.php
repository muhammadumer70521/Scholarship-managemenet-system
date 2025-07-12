
<?php session_start();

include 'config/db_connect.php';

$scholarships = [];
$result = $conn->query("SELECT scholarship_id, title FROM scholarships");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scholarships[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Scholarship Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="description" content="Manage scholarship applications easily with our modern and secure system.">
    <!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    * {
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }

    body {
        background-color: #fdfdfd;
        color: #333;
        margin: 0;
        padding: 0;
        /* margin-right: -83px; */
    }
    

    .hero-section {
        background: linear-gradient(to bottom right, rgba(0,0,0,0.6), rgba(0,0,0,0.3)),
                    url('abc.jpg') no-repeat center center/cover;
        height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        flex-direction: column;
        padding: 0 20px;
    }

    .hero-section h1 {
        font-size: 3.2rem;
        font-weight: 700;
    }

    .hero-section p {
        font-size: 1.25rem;
        max-width: 600px;
        margin: 10px auto;
    }

    .btn-lg {
        padding: 14px 28px;
        font-size: 1.1rem;
        border-radius: 8px;
    }

    .info-section {
        padding: 60px 0;
    }

    .info-box {
        padding: 30px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    h2 {
        font-weight: 600;
        margin-bottom: 30px;
        color: #222;
    }

    .testimonial-box {
        background: #ffffff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    footer {
        background: #1f1f1f;
        color: #bbb;
        padding: 20px 0;
        font-size: 0.95rem;
    }

    nav.navbar {
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .navbar-nav .nav-link {
        margin: 0 10px;
        font-weight: 500;
        color: #f0f0f0 !important;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .btn-outline-light {
        border-radius: 6px;
    }

    @media screen and (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }
    }
    @media (max-width: 768px) {
  .navbar-nav .nav-item {
    margin-bottom: 10px;
  }
}

</style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3" >
    <div class="container">
        <a class="navbar-brand fw-bold" href="#" style="margin-left: -30px; ">🎓 Scholarship Management</a>
            
        <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="view_scholarship.php">Scholarships</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#feedback">Feedbacks</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <?php if (isset($_SESSION['student_id']) || isset($_SESSION['admin_logged_in'])): ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section">
    <h1 class="display-4 fw-bold">Smarter Scholarship Management</h1>
    <p class="lead">Automate, manage, and streamline your scholarship applications with ease.</p>
    <a href="login.php" class="btn btn-warning btn-lg mt-3">Start Now</a>
</section>

<section class="info-section" id="features">
    <div class="container">
        <h2 class="text-center mb-5">🚀 Key Features</h2>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="info-box h-100">
                    <h5 class="fs-5">📋 Student Registration</h5>
                    <p>Easy and secure signup process to register for the scholarship system.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="info-box h-100">
                    <h5 class="fs-5">📝 Apply for Scholarships</h5>
                    <p>Students can view eligible scholarships and apply directly online.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="info-box h-100">
                    <h5 class="fs-5">📤 Admin Controls</h5>
                    <p>Admins can easily approve, reject, or review applications.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="feedback" class="testimonial-section bg-light py-5">
  <div class="container">
    <h2 class="text-center mb-5">💬 What Students Say</h2>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="testimonial-box mx-auto" style="max-width: 600px;">
            <p class="mb-3">"Amazing system – I applied for two scholarships in minutes!"</p>
            <p class="text-end fw-bold mb-0">– Ahmad, CS Student</p>
          </div>
        </div>
        <div class="carousel-item">
          <div class="testimonial-box mx-auto" style="max-width: 600px;">
            <p class="mb-3">"Smooth interface and very secure. Great work!"</p>
            <p class="text-end fw-bold mb-0">– Haseeb, IT Student</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>



<section class="info-section bg-white py-5" id="contact">
  <div class="container">
    <h2 class="text-center mb-4">📬 Contact Us</h2>
    <p class="text-center text-muted mb-5">Feel free to reach out for queries, support, or just a hello 👋</p>
    
    <div class="row g-5">
      <!-- Contact Info Cards -->
      <div class="col-md-4" data-aos="fade-up">
        <div class="info-box text-center h-100 shadow-sm">
          <img src="https://cdn-icons-png.flaticon.com/512/455/455705.png" width="50" class="mb-3" />
          <h5>Call Us</h5>
          <p class="mb-0">0314-6076283</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="info-box text-center h-100 shadow-sm">
          <img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" width="50" class="mb-3" />
          <h5>Email Us</h5>
          <p class="mb-0">mumer3027@gmail.com</p>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="info-box text-center h-100 shadow-sm">
          <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" width="50" class="mb-3" />
          <h5>Visit</h5>
          <p class="mb-0">University Rd, City Name, Pakistan</p>
        </div>
      </div>
    </div>

    <!-- Contact Form + Map -->
    <div class="row mt-5 g-4">
      <!-- Contact Form -->
      <div class="col-md-6" data-aos="fade-right">
        <form action="contact_process.php" method="POST" class="p-4 bg-light rounded shadow-sm needs-validation" novalidate>
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" required>
            <div class="invalid-feedback">Please enter your name.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" required>
            <div class="invalid-feedback">Please enter a valid email.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea class="form-control" rows="4" name="message" required></textarea>
            <div class="invalid-feedback">Please enter a message.</div>
          </div>
          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
      </div>

      <!-- Google Map -->
      <div class="col-md-6" data-aos="fade-left">
        <div class="ratio ratio-4x3 rounded shadow-sm">
          <iframe src="https://maps.google.com/maps?q=University%20Road,%20Karachi&t=&z=13&ie=UTF8&iwloc=&output=embed"
            frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>


<footer class="text-center">
  <div class="mb-2">
    <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
    <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
    <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
    <a href="#" class="text-light"><i class="fab fa-linkedin fa-lg"></i></a>
  </div>
  &copy; <?php echo date("Y"); ?> Scholarship Management System — Designed by Muhammad Umer.
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();

</script>

</body>
</html>
