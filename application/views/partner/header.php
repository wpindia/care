<!DOCTYPE html>
<html lang="en" id="daycare">
<head>
	<base href="<?php echo partner_base_url() ?>">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="favicon.ico">
	<link rel="manifest" href="/manifest.json">
	<meta name="apple-mobile-web-app-title" content="DayCare">
	<meta name="application-name" content="DayCare">
	<meta name="theme-color" content="#ffffff">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>DayCare</title>

	<?php
		echo loadCSS($this->data['pageName']);
	?>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	
	
</head>
<body id="<?php echo $this->data['pageName']?>">
<?php
		$allFixedFlashMessage = array();
		$allFixedFlashMessage['set_flashdata'] = $this->session->flashdata('set_flashdata');
		$allFixedFlashMessage = array_filter($allFixedFlashMessage);
		if(!empty($allFixedFlashMessage)){
			echo '<div class="message-section timeout" id="message_alert_box" >';
			foreach ($allFixedFlashMessage as $key => $message) {
				$tmpClass='success';
				if(is_array($message)){
					$status = $message['status'];
					$message = $message['message'];
					if($status > 100){
						$message = '';
						continue;
					}else if($status != 1){
						$tmpClass='error';
					}
				}
				if(is_string($message) && $message != ''){
					echo '<div id="card-alert" class="card '.$tmpClass.'">
					<div class="card-content center"><p>'.$message.'</p></div>
					</div>';
				}
			}
			echo "</div>";
		}
		?>