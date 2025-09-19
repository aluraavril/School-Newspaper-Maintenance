<?php require_once 'writer/classloader.php';
$userObj = new User();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background-color: #FFFDF5;
    }

    h1,
    h2,
    h3 {
      font-family: 'Fredoka One', cursive;
    }

    .navbar-title {
      font-family: Arial, sans-serif;
      letter-spacing: -1px;
    }

    .text-outline {
      text-shadow: 2px 2px 0 #000, -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000;
    }

    .articles-bg {
      background-color: #FFD93D;
    }
  </style>
  <title>School Newspaper 📰</title>
</head>

<body class="flex flex-col min-h-screen">

  <!-- Hero Section with Navbar -->
  <section class="relative h-[90vh] w-full">
    <img src="https://png.pngtree.com/background/20250217/original/pngtree-drawing-pictures-group-of-happy-kids-is-outdoors-on-the-sportive-picture-image_15542977.jpg"
      alt="School kids background" class="w-full h-full object-cover">

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/60"></div>

    <!-- Navbar -->
    <header class="absolute top-0 left-0 right-0 z-20 px-8 py-5 flex justify-between items-center">
      <h1 class="navbar-title text-3xl text-white drop-shadow-lg">School Newspaper</h1>
      <nav class="flex items-center gap-8 text-lg font-semibold text-white">
        <a href="writer/login.php" class="hover:text-[#FFD93D] transition">Writer Login</a>
        <a href="admin/login.php" class="hover:text-[#FFD93D] transition">Admin Login</a>
      </nav>
    </header>


    <!-- Hero Text -->
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 z-10">
      <h2 class="text-6xl md:text-7xl text-[#FFD93D] text-outline mb-6">Welcome to Our School Newspaper!</h2>
      <p class="text-2xl md:text-3xl text-white drop-shadow-lg max-w-3xl mb-8">
        A colorful space where students share stories, news, and creativity!
      </p>
      <!-- ✅ Register CTA Button -->
      <a href="writer/register.php"
        class="bg-gradient-to-r from-[#FFD93D] to-[#FFB830] text-[#3C9EE7] px-8 py-3 rounded-full font-semibold shadow-md hover:scale-110 hover:shadow-lg transition">
        Register as a Writer Now!
      </a>
    </div>
  </section>

  <!-- Top Writers Section -->
  <section class="py-16 bg-[#FFF9E6] text-center">
    <h2 class="text-4xl text-[#3C9EE7] font-bold mb-10">⭐ Top Writers of the Month ⭐</h2>
    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
      <div class="bg-white shadow-lg rounded-2xl p-6">
        <img src="https://i.pravatar.cc/150?img=12" alt="Top Writer"
          class="w-24 h-24 mx-auto rounded-full border-4 border-[#FFD93D] mb-4">
        <h3 class="text-2xl font-bold text-[#6BCB77]">John Doe</h3>
        <p class="text-gray-600 mt-2">Outstanding contributions this month! 🎉</p>
      </div>
      <div class="bg-white shadow-lg rounded-2xl p-6">
        <img src="https://i.pravatar.cc/150?img=20" alt="Top Writer"
          class="w-24 h-24 mx-auto rounded-full border-4 border-[#FFD93D] mb-4">
        <h3 class="text-2xl font-bold text-[#6BCB77]">Jane Smith</h3>
        <p class="text-gray-600 mt-2">Creative and inspiring storytelling ✨</p>
      </div>
      <div class="bg-white shadow-lg rounded-2xl p-6">
        <img src="https://i.pravatar.cc/150?img=32" alt="Top Writer"
          class="w-24 h-24 mx-auto rounded-full border-4 border-[#FFD93D] mb-4">
        <h3 class="text-2xl font-bold text-[#6BCB77]">Alice Lee</h3>
        <p class="text-gray-600 mt-2">Great reporting and insights 📚</p>
      </div>
    </div>
  </section>


  <!-- Latest Articles -->
  <main class="articles-bg px-6 py-16 flex-grow">
    <h2 class="text-3xl text-center text-[#3C9EE7] mb-10">Latest Articles</h2>
    <div class="grid md:grid-cols-2 gap-10 max-w-6xl mx-auto">
      <?php
      $articleObj = new Article();
      $articles = $articleObj->getActiveArticles();
      ?>
      <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
          <div class="bg-white rounded-2xl shadow-md overflow-hidden flex hover:shadow-xl transition">
            <?php if (!empty($article['image_path'])): ?>
              <img src="<?php echo htmlspecialchars(str_replace('./', '', $article['image_path'])); ?>"
                alt="Article Image" class="w-1/3 object-cover">
            <?php endif; ?>
            <div class="p-6 flex flex-col justify-between w-2/3">
              <div>
                <!-- Title in Arial -->
                <h3 class="text-xl font-bold font-sans mb-1"><?php echo htmlspecialchars($article['title']); ?></h3>
                <!-- Writer + Date -->
                <p class="text-sm text-gray-600 mb-3">
                  by <?php echo htmlspecialchars($article['username']); ?><br>
                  <?php echo date("M j, Y", strtotime($article['created_at'])); ?>
                </p>
                <!-- Short preview -->
                <p class="text-gray-700 text-sm mb-4">
                  <?php echo nl2br(htmlspecialchars(substr($article['content'], 0, 120))); ?>...
                </p>
              </div>
              <div>
                <a href="#" class="inline-block bg-[#3C9EE7] text-white px-4 py-2 rounded-lg font-semibold text-sm shadow hover:bg-blue-700 transition">
                  Read More
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-500">No articles yet. Be the first to write one! ✍</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-[#3C9EE7] text-white mt-auto">
    <div class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10">

      <!-- About Section -->
      <div>
        <h3 class="text-xl font-bold mb-4">🏫 About School Newspaper</h3>
        <p class="text-sm leading-relaxed">
          The official digital publication of our school.
          A platform where students share news, stories, and creative works.
          Together we build a vibrant voice for our community.
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-xl font-bold mb-4">🔗 Quick Links</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="index.php" class="hover:underline">Home</a></li>
          <li><a href="writer/login.php" class="hover:underline">Writer Login</a></li>
          <li><a href="admin/login.php" class="hover:underline">Admin Login</a></li>
          <li><a href="#" class="hover:underline">Latest Articles</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h3 class="text-xl font-bold mb-4">📬 Contact Us</h3>
        <p class="text-sm">School Newspaper Office</p>
        <p class="text-sm">123 Campus Avenue, School City</p>
        <p class="text-sm mt-2">✉ Email: schoolpaper@example.com</p>
        <p class="text-sm">☎ Phone: (123) 456-7890</p>
      </div>

    </div>


</body>

</html>