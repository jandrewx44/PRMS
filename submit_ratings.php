<?php

// Never expose internal errors to users from this endpoint.
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

$isJsonRequest = isset($_POST['action']);

set_exception_handler(function ($e) use (&$isJsonRequest) {
	error_log('submit_ratings.php exception: ' . $e->getMessage());
	if (!headers_sent()) {
		if ($isJsonRequest) {
			header('Content-Type: application/json');
		} else {
			header('Content-Type: text/plain; charset=UTF-8');
		}
	}
	if ($isJsonRequest) {
		echo json_encode(array('status' => 'error', 'message' => 'Unable to process request.'));
	} else {
		echo 'Unable to submit review right now.';
	}
	exit;
});

set_error_handler(function ($severity, $message, $file, $line) {
	if (!(error_reporting() & $severity)) {
		return false;
	}
	throw new ErrorException($message, 0, $severity, $file, $line);
});

register_shutdown_function(function () use (&$isJsonRequest) {
	$error = error_get_last();
	if ($error !== null) {
		error_log('submit_ratings.php fatal: ' . $error['message']);
		if (!headers_sent()) {
			if ($isJsonRequest) {
				header('Content-Type: application/json');
			} else {
				header('Content-Type: text/plain; charset=UTF-8');
			}
		}
		if ($isJsonRequest) {
			echo json_encode(array('status' => 'error', 'message' => 'Unable to process request.'));
		} else {
			echo 'Unable to submit review right now.';
		}
	}
});

try {
	$getEnvValue = function ($keys, $default = '') {
		foreach ((array)$keys as $key) {
			$value = getenv($key);
			if ($value !== false && $value !== '') {
				return $value;
			}
			if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
				return $_ENV[$key];
			}
			if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
				return $_SERVER[$key];
			}
		}
		return $default;
	};

	$dbHost = $getEnvValue(array('DB_HOST', 'MYSQL_HOST', 'COOLIFY_DATABASE_HOST'), 'localhost');
	$dbPort = $getEnvValue(array('DB_PORT', 'MYSQL_PORT', 'COOLIFY_DATABASE_PORT'), '3306');
	$dbName = $getEnvValue(array('DB_DATABASE', 'MYSQL_DATABASE', 'DB_NAME'), '2906898_mpcdatabase');
	$dbUser = $getEnvValue(array('DB_USERNAME', 'MYSQL_USER', 'DB_USER'), 'root');
	$dbPass = $getEnvValue(array('DB_PASSWORD', 'MYSQL_PASSWORD', 'DB_PASS'), '');

	$dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
	$connect = new PDO($dsn, $dbUser, $dbPass);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	if (isset($_POST["rating_data"])) {
		$userName = trim((string)($_POST["user_name"] ?? ''));
		$userReview = trim((string)($_POST["user_review"] ?? ''));
		$userRating = (int)($_POST["rating_data"] ?? 0);

		if ($userName === '' || $userReview === '' || $userRating < 1 || $userRating > 5) {
			echo "Unable to submit review right now.";
			exit;
		}

		$data = array(
			':user_name' => $userName,
			':user_rating' => $userRating,
			':user_review' => $userReview,
			':user_email' => '',
			':datetime' => time()
		);

		$query = "
		INSERT INTO tbl_review 
		(user_name, user_rating, user_review, user_email, datetime)
		VALUES (:user_name, :user_rating, :user_review, :user_email, :datetime)
		";

		$statement = $connect->prepare($query);
		$statement->execute($data);

		echo "Your Review & Rating Successfully Submitted";
		exit;
	}

	if (isset($_POST["action"])) {
		$isJsonRequest = true;

		$average_rating = 0;
		$total_review = 0;
		$five_star_review = 0;
		$four_star_review = 0;
		$three_star_review = 0;
		$two_star_review = 0;
		$one_star_review = 0;
		$total_user_rating = 0;
		$review_content = array();

		$query = "
		SELECT * FROM tbl_review 
		ORDER BY review_id DESC
		";

		$result = $connect->query($query);

		foreach ($result as $row) {
			$rating = (int)$row["user_rating"];
			$review_content[] = array(
				'user_name' => (string)$row["user_name"],
				'user_review' => (string)$row["user_review"],
				'rating' => $rating,
				'datetime' => date('l jS, F Y h:i:s A', (int)$row["datetime"])
			);

			if ($rating === 5) { $five_star_review++; }
			if ($rating === 4) { $four_star_review++; }
			if ($rating === 3) { $three_star_review++; }
			if ($rating === 2) { $two_star_review++; }
			if ($rating === 1) { $one_star_review++; }

			$total_review++;
			$total_user_rating += $rating;
		}

		$average_rating = ($total_review > 0) ? ($total_user_rating / $total_review) : 0;

		$output = array(
			'average_rating' => number_format($average_rating, 1),
			'total_review' => $total_review,
			'five_star_review' => $five_star_review,
			'four_star_review' => $four_star_review,
			'three_star_review' => $three_star_review,
			'two_star_review' => $two_star_review,
			'one_star_review' => $one_star_review,
			'review_data' => $review_content
		);

		header('Content-Type: application/json');
		echo json_encode($output);
		exit;
	}
} catch (Throwable $e) {
	error_log('submit_ratings.php throwable: ' . $e->getMessage());
	if ($isJsonRequest) {
		header('Content-Type: application/json');
		echo json_encode(array('status' => 'error', 'message' => 'Unable to process request.'));
	} else {
		echo 'Unable to submit review right now.';
	}
	exit;
}

?>
