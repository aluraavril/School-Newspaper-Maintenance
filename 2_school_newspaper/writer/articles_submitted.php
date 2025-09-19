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

  <!-- Navbar -->
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

  <main class="px-6 py-16 flex-grow max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold text-[#5C3D2E] text-center mb-10 drop-shadow-md">
      Your Submitted Articles
    </h2>

    <div class="grid md:grid-cols-2 gap-10">
      <?php
      $articleObj = new Article();
      $articles = $articleObj->getArticlesByUserID($_SESSION['user_id']);
      ?>
      <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
          <div class="bg-[#FFE066] rounded-2xl shadow-md overflow-hidden flex hover:shadow-xl transition">
            <?php if (!empty($article['image_path'])): ?>
              <img src="/schoolpaper/2_school_newspaper/<?php echo htmlspecialchars($article['image_path']); ?>"
                alt="Article Image" class="w-1/3 object-cover rounded-l-2xl" />
            <?php else: ?>
              <div class="w-1/3 bg-gray-200 rounded-l-2xl flex items-center justify-center text-gray-400">
                No Image
              </div>
            <?php endif; ?>

            <div class="p-6 flex flex-col justify-between w-2/3">
              <div>
                <h3 class="text-xl font-bold text-[#5C3D2E] mb-2"><?php echo htmlspecialchars($article['title']); ?></h3>
                <p class="text-sm text-gray-700 mb-3">
                  by <?php echo htmlspecialchars($article['username']); ?><br />
                  <?php echo date("F j, Y", strtotime($article['created_at'])); ?>
                </p>
                <p class="text-[#5C3D2E] whitespace-pre-line mb-4">
                  <?php echo nl2br(htmlspecialchars(substr($article['content'], 0, 150))); ?>...
                </p>
              </div>

              <div class="flex justify-end gap-4">
                <form class="deleteArticleForm">
                  <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id" />
                  <button type="submit"
                    class="bg-red-500 text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-red-600 transition">
                    Delete
                  </button>
                </form>
                <button class="edit-toggle bg-orange-500 text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-orange-600 transition">
                  Edit Article
                </button>
              </div>

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
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-700">You have not submitted any articles yet.</p>
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
        $(this).closest('div').siblings('.updateArticleForm').toggleClass('hidden');
      });

      $('.deleteArticleForm').on('submit', function(event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).find('.article_id').val(),
          deleteArticleBtn: 1
        };
        if (confirm("Are you sure you want to delete this article?")) {
          $.ajax({
            type: "POST",
            url: "core/handleForms.php",
            data: formData,
            success: function(data) {
              if (data) {
                location.reload();
              } else {
                alert("Deletion failed");
              }
            }
          });
        }
      });
    });
  </script>

</body>

</html>