<?php require_once 'classloader.php'; ?>

<?php
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
}
?>
<?php include 'includes/navbar.php'; ?>

<div class="max-w-4xl mx-auto">
  <h2 class="text-2xl font-semibold text-primary text-center mb-10">Your Submitted Articles</h2>

  <div class="space-y-6">
    <?php
    $articleObj = new Article();
    $articles = $articleObj->getArticlesByUserID($_SESSION['user_id']);
    ?>
    <?php if (!empty($articles)): ?>
      <?php foreach ($articles as $article): ?>
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md articleCard">
          <?php if (!empty($article['image_path'])): ?>
            <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" alt="Article Image" class="rounded-t-2xl w-full h-48 object-cover">
          <?php endif; ?>
          <div class="p-6">
            <h3 class="text-lg font-semibold text-primary"><?php echo htmlspecialchars($article['title']); ?></h3>
            <div class="flex items-center gap-2 text-sm text-gray-500 mt-2 mb-4">
              <span><?php echo htmlspecialchars($article['username']); ?></span>
              <span>&bull;</span>
              <span><?php echo date("F j, Y", strtotime($article['created_at'])); ?></span>
            </div>
            <p class="text-gray-700 mb-4">
              <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </p>

            <div class="flex items-center justify-end mt-4">
              <form class="deleteArticleForm">
                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-red-600 deleteArticleBtn">Delete</button>
              </form>
            </div>

            <div class="updateArticleForm hidden mt-6">
              <h4 class="text-lg font-semibold text-primary mb-4">Edit Article</h4>
              <form action="core/handleForms.php" method="POST">
                <div class="mb-4">
                  <input type="text" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <div class="mb-4">
                  <textarea name="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($article['content']); ?></textarea>
                  <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                </div>
                <button type="submit" name="editArticleBtn" class="w-full bg-primary text-white px-5 py-3 rounded-lg font-semibold text-sm hover:bg-blue-700">Save Changes</button>
              </form>
            </div>
            <button class="mt-4 text-sm text-primary hover:underline edit-toggle">Edit Article</button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-gray-500">You have not submitted any articles yet.</p>
    <?php endif; ?>
  </div>
</div>

</main>
<footer class="bg-primary text-white text-center py-4 mt-auto">
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