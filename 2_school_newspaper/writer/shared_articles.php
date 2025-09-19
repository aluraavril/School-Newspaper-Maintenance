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

  <main class="px-6 py-16 flex-grow max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold text-[#5C3D2E] text-center mb-10 drop-shadow-md">
      Shared Articles
    </h2>

    <div class="space-y-6">
      <?php
      $permissionObj = new ArticlePermission();
      $articles = $permissionObj->getSharedArticles($_SESSION['user_id']);
      ?>
      <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
          <div class="bg-[#FFE066] border-4 border-[#5C3D2E] rounded-2xl shadow-md overflow-hidden">
            <?php if (!empty($article['image_path'])): ?>
              <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" alt="Article Image" class="rounded-t-2xl w-full h-48 object-cover" />
            <?php endif; ?>
            <div class="p-6">
              <h3 class="text-lg font-bold text-[#5C3D2E] mb-2"><?php echo htmlspecialchars($article['title']); ?></h3>
              <div class="flex items-center gap-2 text-sm text-gray-600 mt-2 mb-4">
                <span><?php echo htmlspecialchars($article['username']); ?></span>
                <span>&bull;</span>
                <span><?php echo date("F j, Y", strtotime($article['created_at'])); ?></span>
              </div>
              <p class="text-[#5C3D2E] whitespace-pre-line mb-4">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
              </p>

              <div class="updateArticleForm hidden mt-6">
                <h4 class="text-2xl font-bold text-[#5C3D2E] mb-4">Edit Article</h4>
                <form action="core/handleForms.php" method="POST">
                  <div class="mb-4">
                    <input type="text" name="title" value="<?php echo htmlspecialchars($article['title']); ?>"
                      class="w-full px-4 py-2 border-2 border-[#5C3D2E] rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" />
                  </div>
                  <div class="mb-4">
                    <textarea name="description" rows="5"
                      class="w-full px-4 py-2 border-2 border-[#5C3D2E] rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"><?php echo htmlspecialchars($article['content']); ?></textarea>
                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" />
                  </div>
                  <button type="submit" name="editArticleBtn"
                    class="w-full bg-orange-500 text-white px-5 py-3 rounded-lg font-bold text-sm hover:bg-orange-600 transition">
                    Save Changes
                  </button>
                </form>
              </div>
              <button class="mt-4 bg-orange-500 text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-orange-600 transition edit-toggle">
                Edit Article
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-600">No articles have been shared with you.</p>
      <?php endif; ?>
    </div>
  </main>

  <footer class="bg-[#5C3D2E] text-white text-center py-4 mt-auto">
    <p>&copy; <?php echo date("Y"); ?> School Publication. All Rights Reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script>
    $(document).ready(function() {
      $('.edit-toggle').on('click', function() {
        $(this).siblings('.updateArticleForm').toggleClass('hidden');
      });
    });
  </script>

</body>

</html>