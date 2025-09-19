<?php require_once 'classloader.php'; ?>

<?php
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
  exit;
}
if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
  exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background: url("https://img.freepik.com/free-vector/blank-white-notepaper-design-vector_53876-161340.jpg") repeat;
      background-size: auto;
      /* Prevent zoom */
      background-position: center;
    }

    h1,
    h2,
    h3 {
      font-family: 'Fredoka One', cursive;
    }

    .navbar-brand {
      font-family: 'Fredoka One', cursive;
      letter-spacing: -1px;
    }

    .text-outline {
      text-shadow: 2px 2px 0 #000, -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">

  <?php include 'includes/navbar.php'; ?>

  <div class="w-full px-6 sm:px-8 lg:px-10 flex gap-8 h-[calc(100vh-100px)] mt-6">
    <!-- Left Column: Submit New Article (approx 60%) -->
    <div class="flex-[3] bg-[#FFE066] border-4 border-[#5C3D2E] p-8 rounded-2xl shadow-lg h-fit sticky top-40 self-start">
      <?php
      if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        $status_class = $_SESSION['status'] == "200" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800";
        echo "<div class='{$status_class} p-4 rounded-lg text-center mb-4 font-semibold'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
        unset($_SESSION['status']);
      }
      ?>
      <h2 class="text-3xl md:text-4xl font-bold text-[#5C3D2E] text-center mb-6 drop-shadow-md">
        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
      </h2>

      <h3 class="text-xl font-bold text-[#5C3D2E] mb-6">📝 Write Your New Article</h3>
      <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="title" class="block text-[#5C3D2E] font-semibold mb-2">Title</label>
          <input type="text" id="title" name="title" placeholder="Article Title"
            class="w-full px-4 py-2 border-2 border-[#5C3D2E] rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" />
        </div>

        <div class="mb-4">
          <label for="description" class="block text-[#5C3D2E] font-semibold mb-2">Content</label>
          <textarea id="description" name="description" placeholder="Write your article here." rows="6"
            class="w-full px-4 py-2 border-2 border-[#5C3D2E] rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
        </div>

        <div class="mb-4">
          <label for="image" class="block text-[#5C3D2E] font-semibold mb-2">Image</label>
          <input type="file" id="image" name="image"
            class="w-full px-4 py-2 border-2 border-[#5C3D2E] rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" />
        </div>

        <button type="submit" name="insertArticleBtn"
          class="w-full bg-orange-500 text-white px-5 py-3 rounded-lg font-bold text-sm hover:bg-orange-600 transition">
          🚀 Submit
        </button>
      </form>
    </div>

    <!-- Right Column: All Articles (approx 40%) -->
    <div class="flex-[2] flex flex-col h-[calc(100vh-100px)]">
      <!-- Floating Heading -->
      <h3 class="text-3xl md:text-4xl font-bold text-black mb-6 sticky top-28 z-10 text-center">
        📚 All Articles
      </h3>

      <!-- Scrollable Content -->
      <div class="flex-1 overflow-y-auto pr-2 space-y-6">
        <?php
        $articleObj = new Article();
        $articles = $articleObj->getActiveArticles();
        ?>
        <?php if (!empty($articles)): ?>
          <?php foreach ($articles as $article): ?>
            <div class="bg-white border-2 border-[#5C3D2E] rounded-2xl shadow-md">
              <?php if (!empty($article['image_path'])): ?>
                <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" alt="Article Image"
                  class="rounded-t-2xl w-full h-40 object-cover" />
              <?php endif; ?>
              <div class="p-6">
                <h3 class="text-lg font-bold text-[#5C3D2E]"><?php echo htmlspecialchars($article['title']); ?></h3>
                <div class="flex items-center gap-2 text-sm text-gray-600 mt-2 mb-4">
                  <span><?php echo htmlspecialchars($article['username']); ?></span>
                  <span>&bull;</span>
                  <span><?php echo date("F j, Y", strtotime($article['created_at'])); ?></span>
                  <?php if ($article['is_admin'] == 1): ?>
                    <span class="bg-yellow-200 text-[#5C3D2E] px-2 py-1 rounded-full text-xs font-semibold">Admin Post</span>
                  <?php endif; ?>
                </div>
                <p class="text-gray-800">
                  <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </p>
                <?php if ($_SESSION['user_id'] != $article['author_id']): ?>
                  <div class="mt-4">
                    <form action="core/handleForms.php" method="POST">
                      <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" />
                      <input type="hidden" name="author_id" value="<?php echo $article['author_id']; ?>" />
                      <button type="submit" name="requestEditBtn"
                        class="bg-orange-500 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-orange-600 transition">
                        ✏ Request Edit
                      </button>
                    </form>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-gray-600">No articles found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>

</html>