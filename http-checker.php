<?php
$errMsg = '';
$httpWithCodes = [];

if (isset($_POST['generate_http_code'])) {
	$token = isset($_POST['token']) ? $_POST['token'] : '';
	if (!$token || $token != $_SESSION['token']) {
		throw new Exception('Alien is not a human.');
	}
	try {
		if ($_FILES['file']['error']) {
			throw new Exception('Submitted file has an error');
		}
		$tmpFile = $_FILES['file']['tmp_name'];
		$fileName = $_FILES['file']['name'];
		$fileNameArr = explode('.', $fileName);
		$filExt = strtolower(end($fileNameArr));

		if ($filExt != 'csv') {
			throw new Exception('File must .csv format.');
		}

		$urls = [];
		if ($streamFile = fopen($tmpFile, 'r')) {
			while ($data = fgetcsv($streamFile, 1000, ',')) {
				if (!empty($data)) {
					$urls[] = $data[0];
				}
			}
		}
		if (!empty($urls)) {
			foreach ($urls as $url) {
				if (!empty($url)) {
					$code = 404; // Default to 404
					if (strpos($url, 'http') !== false) {
						$status = get_headers($url);
						$code = substr($status[0], 9, 3);
					}				
					$httpWithCodes[$url] = $code;
				}				
			}
		}
	} catch (Exception $e) {
		$errMsg = $e->getMessage();
	}
}