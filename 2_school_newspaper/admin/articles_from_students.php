<?php require_once 'classloader.php'; ?>

<?php
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
  exit;
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
  exit;
}
?>
<?php include 'includes/navbar.php'; ?>

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

    .articleCard {
      background-color: #FFE066;
      border-radius: 1rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      transition: box-shadow 0.3s ease;
    }

    .articleCard:hover {
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }

    .articleImage {
      width: 30%;
      object-fit: cover;
      border-top-left-radius: 1rem;
      border-bottom-left-radius: 1rem;
    }

    .noImagePlaceholder {
      width: 30%;
      background-color: #e5e7eb;
      border-top-left-radius: 1rem;
      border-bottom-left-radius: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #9ca3af;
      font-size: 1rem;
    }

    .articleContent {
      padding: 1.5rem;
      width: 70%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .articleTitle {
      font-size: 1.25rem;
      font-weight: 700;
      color: #5C3D2E;
      margin-bottom: 0.5rem;
    }

    .articleMeta {
      font-size: 0.875rem;
      color: #4B5563;
      margin-bottom: 1rem;
    }

    .articleContentText {
      color: #5C3D2E;
      white-space: pre-line;
      margin-bottom: 1rem;
      flex-grow: 1;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.875rem;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      transition: background-color 0.3s ease;
      cursor: pointer;
      width: 140px;
      height: 44px;
      text-align: center;
    }

    .btn-delete {
      background-color: #ef4444;
      color: white;
    }

    .btn-delete:hover {
      background-color: #dc2626;
    }

    .btn-edit-toggle {
      background-color: #f97316;
      color: white;
    }

    .btn-edit-toggle:hover {
      background-color: #ea580c;
    }


    .updateArticleForm {
      margin-top: 1.5rem;
      background-color: white;
      padding: 1.5rem;
      border-radius: 1rem;
      border: 2px solid #5C3D2E;
    }

    .updateArticleForm input[type="text"],
    .updateArticleForm textarea {
      width: 100%;
      padding: 0.5rem 1rem;
      border: 2px solid #5C3D2E;
      border-radius: 0.5rem;
      outline: none;
      font-family: inherit;
      font-size: 1rem;
      margin-bottom: 1rem;
      resize: vertical;
    }

    .updateArticleForm button {
      width: 100%;
      background-color: #f97316;
      color: white;
      padding: 0.75rem;
      font-weight: 700;
      border-radius: 0.5rem;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .updateArticleForm button:hover {
      background-color: #ea580c;
    }

    .status-badge {
      padding: 0.25rem 0.5rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .status-pending {
      background-color: #fef3c7;
      color: #b45309;
    }

    .status-active {
      background-color: #bbf7d0;
      color: #15803d;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">

  <main class="px-6 py-16 flex-grow max-w-7xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold text-[#5C3D2E] text-center mb-10 drop-shadow-md">
      Articles
    </h2>

    <div class="space-y-10">
      <?php
      $articleObj = new Article();
      $articles = $articleObj->getArticles();
      ?>
      <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
          <div class="articleCard">
            <?php if (!empty($article['image_path'])): ?>
              <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" alt="Article Image" class="articleImage" />
            <?php else: ?>
              <div class="noImagePlaceholder">No Image</div>
            <?php endif; ?>
            <div class="articleContent">
              <div>
                <h3 class="articleTitle"><?php echo htmlspecialchars($article['title']); ?></h3>
                <div class="articleMeta">
                  <span><?php echo htmlspecialchars($article['username']); ?></span>
                  <span> &bull; </span>
                  <span><?php echo date("F j, Y", strtotime($article['created_at'])); ?></span>
                  <?php if ($article['is_active'] == 0): ?>
                    <span class="status-badge status-pending ml-4">Pending</span>
                  <?php else: ?>
                    <span class="status-badge status-active ml-4">Active</span>
                  <?php endif; ?>
                </div>
                <p class="articleContentText"><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
              </div>

              <div class="flex justify-end gap-4 mt-4">
                <form class="deleteArticleForm">
                  <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" />
                  <button type="submit" class="btn btn-delete">Delete</button>
                </form>
                <button class="edit-toggle btn btn-edit-toggle">Edit Article</button>
              </div>

              <div class="updateArticleForm hidden">
                <h4 class="text-2xl font-bold text-[#5C3D2E] mb-4">Edit Article</h4>
                <form action="core/handleForms.php" method="POST">
                  <input type="text" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" />
                  <textarea name="description" rows="5"><?php echo htmlspecialchars($article['content']); ?></textarea>
                  <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" />
                  <button type="submit" name="editArticleBtn">Save Changes</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-700">No articles from students found.</p>
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
        $(this).closest('.articleCard').find('.updateArticleForm').toggleClass('hidden');
      });

      $('.deleteArticleForm').on('submit', function(event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).find('input[name="article_id"]').val(),
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