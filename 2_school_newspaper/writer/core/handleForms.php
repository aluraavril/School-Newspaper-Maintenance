<?php
require_once '../classloader.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = htmlspecialchars(trim($_POST['username']));
	$email = htmlspecialchars(trim($_POST['email']));
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (!$userObj->usernameExists($username)) {

				if ($userObj->registerUser($username, $email, $password)) {
					header("Location: ../login.php");
				} else {
					$_SESSION['message'] = "An error occured with the query!";
					$_SESSION['status'] = '400';
					header("Location: ../register.php");
				}
			} else {
				$_SESSION['message'] = $username . " as username is already taken";
				$_SESSION['status'] = '400';
				header("Location: ../register.php");
			}
		} else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}
	} else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if (!empty($email) && !empty($password)) {

		if ($userObj->loginUser($email, $password)) {
			header("Location: ../index.php");
		} else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	} else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	$userObj->logout();
	header("Location: ../index.php");
}

if (isset($_POST['insertArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$author_id = $_SESSION['user_id'];

	$image_path = null;


	if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
		$target_dir = __DIR__ . "/../../uploads/"; // absolute path to /uploads/
		if (!is_dir($target_dir)) {
			mkdir($target_dir, 0777, true); // create folder if missing
		}

		$image_name = time() . "_" . basename($_FILES["image"]["name"]);
		$target_file = $target_dir . $image_name;

		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			$image_path = "uploads/" . $image_name; // stored in DB
		} else {
			echo "DEBUG: Failed to move uploaded file. Temp file: " . $_FILES["image"]["tmp_name"];
			exit;
		}
	} else {
		if (isset($_FILES['image'])) {
			echo "DEBUG: File upload error code = " . $_FILES['image']['error'];
			exit;
		}
	}

	if ($articleObj->createArticle($title, $description, $author_id, $image_path)) {
		header("Location: ../index.php");
		exit;
	} else {
		echo "Failed to insert article into DB.";
		exit;
	}
}


if (isset($_POST['editArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$article_id = $_POST['article_id'];
	if ($articleObj->updateArticle($article_id, $title, $description)) {
		header("Location: ../articles_submitted.php");
	}
}

if (isset($_POST['deleteArticleBtn'])) {
	$article_id = $_POST['article_id'];
	echo $articleObj->deleteArticle($article_id);
}


if (isset($_POST['requestEditBtn'])) {
	$article_id = $_POST['article_id'];
	$author_id = $_POST['author_id'];
	$requester_id = $_SESSION['user_id'];

	$editRequestObj = new EditRequest();
	if ($editRequestObj->createRequest($article_id, $requester_id, $author_id)) {
		$notificationObj = new Notification();
		$requester = $userObj->getUserById($requester_id);
		$article = $articleObj->getArticleById($article_id);

		$message = $requester['username'] . " has requested to edit your article '" . $article['title'] . "'.";
		$notificationObj->createNotification($author_id, $message);

		$_SESSION['message'] = "Your request to edit the article has been sent.";
		$_SESSION['status'] = '200';
	}
	header("Location: ../index.php");
	exit;
}


if (isset($_POST['approveEditRequestBtn'])) {
	$request_id = $_POST['request_id'];
	$editRequestObj = new EditRequest();
	$request = $editRequestObj->getRequestById($request_id);

	if ($request) {
		$editRequestObj->updateRequestStatus($request_id, 'approved');

		// Give requester edit permission
		$permissionObj = new ArticlePermission();
		$permissionObj->grantPermission($request['article_id'], $request['requester_id']);

		// Notify requester
		$notificationObj = new Notification();
		$article = $articleObj->getArticleById($request['article_id']);
		$message = "Your request to edit the article '" . $article['title'] . "' has been approved.";
		$notificationObj->createNotification($request['requester_id'], $message);
	}

	header("Location: ../notifications.php");
	exit;
}


if (isset($_POST['rejectEditRequestBtn'])) {
	$request_id = $_POST['request_id'];
	$editRequestObj = new EditRequest();
	$request = $editRequestObj->getRequestById($request_id);

	if ($request) {
		$editRequestObj->updateRequestStatus($request_id, 'rejected');

		// Notify requester
		$notificationObj = new Notification();
		$article = $articleObj->getArticleById($request['article_id']);
		$message = "Your request to edit the article '" . $article['title'] . "' has been rejected.";
		$notificationObj->createNotification($request['requester_id'], $message);
	}

	header("Location: ../notifications.php");
	exit;
}
