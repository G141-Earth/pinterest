<?php
include_once 'post.php';
	class Database
	{
		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "pinterest";
		private $conn = NULL;
		private $sql = NULL;
		private $result = NULL;
		private $row = NULL;

		function __construct()
		{
			$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
		}

		function __destruct()
		{
			$this->conn->close();
		}

		public function detect(string $path) : Array
		{
			$array = [];
			$this->sql = 'SELECT * FROM `file` WHERE dir = "'.$path.'" ORDER BY name';
			$this->result = mysqli_query($this->conn, $this->sql);
			while ($this->row = mysqli_fetch_array($this->result))
			{
				$post = new Post();
				$post->addId($this->row['id']);
				$post->addPinnedState($this->row['rate']);
				$post->addDescription($this->row['description']);
				$post->addLink($this->row['link']);
				$post->addRelativePath($this->row['path']);
				$post->addAlias($this->row['alias']);
				$post->addTime($this->row['upload']);
				array_push($array, $post);
      		}
			return $array;
		}
	}
?>