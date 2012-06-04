<?php

class FileAction {
	
	public function upload() {
		if ($_FILES['file']['error'] > 0) {
			echo "Error: " . $_FILES['file']['error']."<br/>";
		}
		else {
			echo "Upload:" . $_FILES['file']['name'] . '<br/>';
			
		}
	}
}