<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require ('repository.php');

session_start();


$model = new Repository();

if(isset($_POST['nm']) && $_POST['nm'] != '' && isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['task']) && $_POST['task'] != ''){
	
	$stmt = $model->insertData();

	if ($stmt === FALSE) {
		die($link->error);
	}elseif($stmt->execute()) {
		echo "Данные добавлены";
	}
	
	

}elseif(isset($_POST['updateStat']) && $_POST['updateStat'] == true){
	
	$stmt = $model->updateStatus();

	if ($stmt === FALSE) {
		die($link->error);
	}elseif(!isset($_SESSION['user'])) {
		echo "Пожалуйста авторизуйтесь заново!";
	}elseif($stmt->execute()) {
		echo "Данные обновлены";
	}
}elseif(isset($_POST['updFlag']) && $_POST['updFlag'] == 1){
		
	$stmt = $model->updateData();
	

	if ($stmt === FALSE) {
		die($link->error);
	}elseif(!isset($_SESSION['user'])) {
		echo "Пожалуйста авторизуйтесь заново!";
	}elseif($stmt->execute()) {
		echo "Данные обновлены";
	}
		
}elseif(isset($_POST['getFlagAll']) && $_POST['getFlagAll'] == true){
	
	$json = $model->getData();
	
	echo $json;
}


