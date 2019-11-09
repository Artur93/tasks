<?php

class Task {
	private $name;
	private $email;
	private $task;
	
	function setName($name) {
		$this->name = $name;
	}
	
	function setEmail($email) {
		$this->email = $email;
	}
	
	function setTask($task) {
		$this->task = $task;
	}
	
	function getName() {
		return $this->name;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function getTask() {
		return $this->task;
	}
}