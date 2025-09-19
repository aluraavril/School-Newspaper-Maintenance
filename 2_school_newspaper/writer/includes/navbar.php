<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


?>

<nav class="bg-[#5C3D2E] text-white shadow-md sticky top-0 z-50">
  <div class="w-full px-6 sm:px-8 lg:px-10">
    <div class="flex justify-between h-16 items-center max-w-full mx-auto">
      <!-- Left (Site Name / Logo) -->
      <div class="flex-shrink-0">
        <a href="index.php" class="text-xl font-bold hover:text-[#FFD93D] transition">School Publication</a>
      </div>

      <!-- Right (Nav Links) -->
      <div class="flex space-x-6 font-medium">
        <a href="articles_submitted.php" class="hover:text-[#FFD93D] transition">Articles Submitted</a>
        <a href="shared_articles.php" class="hover:text-[#FFD93D] transition">Shared Articles</a>
        <a href="notifications.php" class="hover:text-[#FFD93D] transition">Notifications</a>
        <a href="logout.php" class="hover:text-red-400 transition">Logout</a>
      </div>
    </div>
  </div>
</nav>