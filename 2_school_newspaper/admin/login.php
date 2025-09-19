<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #6B9BD8;
      --accent: #FFE066;
      --light: #FDFDFD;
      --orange: #FF7F32;
    }

    body {
      font-family: 'Instrument Sans', sans-serif;
      background: url('https://cdn.vectorstock.com/i/500p/49/72/flower-crayon-watercolor-spring-floral-set-hand-vector-57884972.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .bg-orange {
      background-color: var(--orange);
    }

    .text-orange {
      color: var(--orange);
    }
  </style>
  <title>Admin Login - School Newspaper</title>
</head>

<body class="flex flex-col min-h-screen">

  <div class="flex-grow flex items-center justify-center px-4">
    <div class="w-full max-w-md p-8 space-y-6 bg-white/90 rounded-3xl shadow-lg backdrop-blur relative">
      <!-- Heading -->
      <h2 class="text-2xl font-bold text-center text-orange">Admin Login</h2>

      <!-- Form -->
      <form action="core/handleForms.php" method="POST" class="space-y-6">
        <?php
        session_start();
        if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
          $status_class = $_SESSION['status'] == "200" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800";
          echo "<div class='{$status_class} p-4 rounded-lg text-center'>{$_SESSION['message']}</div>";
          unset($_SESSION['message']);
          unset($_SESSION['status']);
        }
        ?>
        <div>
          <label for="email" class="text-sm font-semibold text-gray-700">Email</label>
          <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        <div>
          <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
          <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        <div>
          <button type="submit" name="loginUserBtn" class="w-full bg-orange text-white px-5 py-3 rounded-2xl font-semibold text-sm shadow hover:bg-orange-600">Login</button>
        </div>
      </form>

      <!-- Bottom links -->
      <div class="flex justify-between text-sm text-gray-600 mt-4">
        <a href="../writer/login.php" class="font-medium text-red-600 hover:underline">Writer Login</a>
        <a href="register.php" class="font-medium text-green-600 hover:underline">Register here</a>
      </div>
    </div>
  </div>

</body>

</html>