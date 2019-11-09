<?php

require ('db.php');

class Repository {
	
	public function insertData() {
        $query = "INSERT INTO tasks(name, email, task, is_done, is_edited) VALUES(?, ?, ?, ?, ?)";
		
		$stmt = $GLOBALS['link']->prepare($query);
		$name = $_POST['nm'];
		$email = $_POST['email'];
		$task = $_POST['task'];
		$is_done = 0;
		$is_edited = 0;
		$stmt->bind_param("sssii", $name, $email, $task, $is_done, $is_edited);
		
        return $stmt;
    }
	
	public function getData() {
        $query = "SELECT id, name, email, task, is_done, is_edited FROM tasks ORDER BY id DESC";
		
		$stmt = $GLOBALS['link']->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $name, $email, $task, $is_done, $is_edited);
		while($stmt->fetch()) {
			$task_id[] = $id;		
			$task_name[] = $this->escape($name);	
			$task_email[] = $this->escape($email);	
			$task_task[] = $this->escape($task);
			$task_is_done[] = $is_done;
			$task_is_edited[] = $is_edited;
		}
		$stmt->close();
		$ar = array('id'=>$task_id, 'name'=>$task_name, 'email'=>$task_email, 'task'=>$task_task, 'is_done'=>$task_is_done, 							'is_edited'=>$task_is_edited);
		$json = json_encode($ar);
		
        return $json;
    }
	
	public function updateData() {
        $query = "UPDATE tasks SET name = ?, email = ?, task = ?,
					is_edited = ?
				  WHERE id = ?";
		
		$id = $_POST['row_id'];
		$name = $_POST['nm'];
		$email = $_POST['em'];
		$task = $_POST['tsk'];
		$is_edited = 1;	

		$stmt = $GLOBALS['link']->prepare($query);

		$stmt->bind_param("sssii", $name, $email, $task, $is_edited, $id);
		
        return $stmt;
    }
	
	public function updateStatus() {
        $query = "UPDATE tasks SET is_done = ? WHERE id = ?";
		
		$id = $_POST['row_id'];
		$is_done = $_POST['stat'];

		$stmt = $GLOBALS['link']->prepare($query);
		$stmt->bind_param("ii", $is_done, $id);
        return $stmt;
    }
	
	public function escape($string) {
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}
	
}