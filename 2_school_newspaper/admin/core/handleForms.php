<?php
require_once '../classloader.php';
require_once '../classes/Notification.php';


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

if (isset($_POST['insertAdminArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$author_id = $_SESSION['user_id'];

	$image_path = null;
	if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
		$target_dir = "../../uploads/";
		$image_name = time() . "_" . basename($_FILES["image"]["name"]);
		$target_file = $target_dir . $image_name;
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			$image_path = "uploads/" . $image_name;
		}
	}

	if ($articleObj->createArticle($title, $description, $author_id, $image_path, 1)) {
		header("Location: ../index.php");
	}
}

if (isset($_POST['editArticleBtn'])) {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$article_id = $_POST['article_id'];

	if ($articleObj->updateArticle($article_id, $title, $description)) {

		$article = $articleObj->getArticleById($article_id);
		if ($article) {
			$author_id = $article['author_id'];
			$notificationObj = new Notification();
			$message = "Your article '" . $title . "' has been edited by an admin.";
			$notificationObj->createNotification($author_id, $message);
		}

		header("Location: ../articles_submitted.php");
	}
}


if (isset($_POST['deleteArticleBtn'])) {
	$article_id = $_POST['article_id'];

	$article = $articleObj->getArticleById($article_id);

	if ($article) {
		$author_id = $article['author_id'];
		$title = $article['title'];

		if ($articleObj->deleteArticle($article_id)) {

			$notificationObj = new Notification();
			$message = "Your article '" . $title . "' has been deleted by an admin.";
			$notificationObj->createNotification($author_id, $message);

			echo true;
		} else {
			echo false;
		}
	} else {
		echo false;
	}
}




if (isset($_POST['updateArticleVisibility'])) {
	$article_id = $_POST['article_id'];
	$status = $_POST['status'];
	echo $articleObj->updateArticleVisibility($article_id, $status);
}
