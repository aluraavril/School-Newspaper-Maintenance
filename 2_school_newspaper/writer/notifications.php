<?php require_once 'classloader.php'; ?>

<?php
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
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

  <?php
  $notificationObj = new Notification();
  $notifications = $notificationObj->getAllNotifications($_SESSION['user_id']);
  $notificationObj->markAllAsRead($_SESSION['user_id']);

  $editRequestObj = new EditRequest();
  $edit_requests = $editRequestObj->getRequestsByAuthor($_SESSION['user_id']);
  ?>

  <main class="px-6 py-16 flex-grow max-w-8xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold text-[#5C3D2E] text-center mb-10 drop-shadow-md">
      Notifications & Edit Requests
    </h2>

    <div class="flex flex-col md:flex-row gap-10">
      <!-- Notifications Column -->
      <section class="flex-1 bg-[#FFE066] border-4 border-[#5C3D2E] rounded-2xl shadow-md p-8 overflow-y-auto">
        <h3 class="text-2xl font-bold text-[#5C3D2E] mb-6">Your Notifications</h3>
        <div class="space-y-4">
          <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
              <div class="p-4 rounded-lg <?php echo $notification['is_read'] ? 'bg-gray-100' : 'bg-blue-100'; ?>">
                <p class="text-[#5C3D2E]"><?php echo htmlspecialchars($notification['message']); ?></p>
                <p class="text-xs text-gray-600 mt-2"><?php echo date("F j, Y, g:i a", strtotime($notification['created_at'])); ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-center text-gray-600">You have no notifications.</p>
          <?php endif; ?>
        </div>
      </section>

      <!-- Edit Requests Column -->
      <section class="flex-1 bg-[#FFE066] border-4 border-[#5C3D2E] rounded-2xl shadow-md p-8 overflow-y-auto">
        <h3 class="text-2xl font-bold text-[#5C3D2E] mb-6">Edit Requests</h3>
        <div class="space-y-4">
          <?php if (!empty($edit_requests)): ?>
            <?php foreach ($edit_requests as $request): ?>
              <div class="p-4 rounded-lg bg-gray-100 flex justify-between items-center">
                <div>
                  <p class="text-[#5C3D2E] font-semibold"><b><?php echo htmlspecialchars($request['username']); ?></b> wants to edit your article: <b><?php echo htmlspecialchars($request['title']); ?></b></p>
                  <p class="text-xs text-gray-600 mt-2"><?php echo date("F j, Y, g:i a", strtotime($request['created_at'])); ?></p>
                </div>
                <div class="flex gap-4">
                  <form action="core/handleForms.php" method="POST">
                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                    <button type="submit" name="approveEditRequestBtn" class="bg-green-500 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-green-600 transition">Approve</button>
                  </form>
                  <form action="core/handleForms.php" method="POST">
                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                    <button type="submit" name="rejectEditRequestBtn" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-600 transition">Reject</button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-center text-gray-600">You have no pending edit requests.</p>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </main>

  <footer class="bg-[#5C3D2E] text-white text-center py-4 mt-auto">
    <p>&copy; <?php echo date("Y"); ?> School Publication. All Rights Reserved.</p>
  </footer>

</body>

</html>