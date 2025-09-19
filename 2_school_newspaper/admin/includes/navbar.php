<!-- <!doctype html>
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
      --light: #F0F8FF;
    }

    body {
      font-family: 'Instrument Sans', sans-serif;
      background-color: var(--light);
    }

    .bg-primary {
      background-color: var(--primary);
    }

    .bg-accent {
      background-color: var(--accent);
    }

    .text-primary {
      color: var(--primary);
    }

    .text-accent {
      color: var(--accent);
    }

    .hero-section {
      background: linear-gradient(135deg, rgba(107, 155, 216, 0.9) 0%, rgba(107, 155, 216, 0.7) 20%), url('uploads/hero.jpg') center/cover;
      min-height: 300px;
    }
  </style>
  <title>Admin - School Publication</title>
</head>

<body class="flex flex-col min-h-screen">

  <header class="bg-primary text-white py-6 shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold"><a href="index.php">Admin Panel</a></h1>
      <div class="flex items-center gap-4">
        <a href="articles_from_students.php" class="text-white hover:text-accent font-medium">Pending Articles</a>
        <a href="articles_submitted.php" class="text-white hover:text-accent font-medium">Submitted Articles</a>
        <a href="core/handleForms.php?logoutUserBtn=1" class="bg-accent text-primary px-4 py-2 rounded-lg hover:bg-yellow-400 font-medium text-sm">Logout</a>
      </div>
    </div>
  </header>

  <main class="container mx-auto px-6 py-12 flex-grow"> -->


<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Optional: You can add user login checks here if needed
// For example, redirect if not logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }
?>

<nav class="bg-[#5C3D2E] text-white shadow-md sticky top-0 z-50">
  <div class="w-full px-6 sm:px-8 lg:px-10">
    <div class="flex justify-between h-16 items-center max-w-full mx-auto">
      <!-- Left (Site Name / Logo) -->
      <div class="flex-shrink-0">
        <a href="index.php" class="text-xl font-bold hover:text-[#FFD93D] transition">Admin Panel</a>
      </div>

      <!-- Right (Nav Links) -->
      <div class="flex space-x-6 font-medium">

        <a href="articles_from_students.php" class="hover:text-[#FFD93D] transition">Articles</a>
        <a href="logout.php" class="hover:text-red-400 transition">Logout</a>
      </div>
    </div>
  </div>
</nav>