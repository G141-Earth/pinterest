<?php
include_once('function.php');
	class Account
	{
		private $user = null;
		private $current = null;
		private $lib = [];
		private $highlight = [];
		private $success = false;
		private $separate = false;
		function __construct($user)
		{
			$f = new Folder(".");
			$this->success = in_array("./{$user}", $f->getFolders());
			if ($this->success)
			{
				$this->user = $user;
				$f = new Folder($user);
				if (in_array("{$user}/segments.json", $f->getFiles()))
				{
					$this->highlight = json_decode(file_get_contents("{$user}/segments.json"), true);
					$this->array_highlight();
				}
				$this->lib = $f->getFolders();
				$this->array_lib();
				sort($this->lib);

			}
		}
		public function getHighlight()
		{
			$curr = $this->current;
			$n = [];
			foreach ($this->highlight as $key => $value)
			{
				$segs = explode('/', $key)[1];
				if (strcmp($segs, $curr) == 0)
				{$n[$key] = $value;}
			}
			return $n;
		}

		public function setCurrent($f)
		{
			$success = in_array($f, $this->lib);
			if($success) { $this->current=$f; }
			return $success;
		}

		public function getCurrent() { return $this->current; }

		public function getUser() { return $this->user; }

		public function getLib() { return $this->lib; }

		public function is_success() { return $this->success; }

		public function is_separate() { return $this->separate; }

		public function switch_separate() { $this->separate = !$this->separate; }

		private function array_highlight()
		{
			foreach ($this->highlight as $key => $value)
			{
				$this->highlight[$this->user.'/'.$key] = $value;
				unset($this->highlight[$key]);
			}
		}

		private function array_lib()
		{
			foreach ($this->lib as $key => $value)
			{
				$segs = explode('/', $value);
				$segs = $segs[count($segs)-1];
				$this->lib[strtolower($value)] = strtolower($segs);
				unset($this->lib[$key]);
			}
		}
	}

	class Folder
	{
		private $dir = null;
		private $hidden = [];
		private $content = [];
		
		function __construct($dir)
		{
			
			$this->dir = $dir;
			$content = array_diff(scandir("{$dir}/"), ['.', '..']);
			$content = array_map(function ($str) use ($dir) { return "{$dir}/".(strtolower($str)); }, $content);
			$this->hidden = array_filter($content, array($this,'in_hidden'));
			$this->content = array_diff($content, $this->hidden);
			sort($this->content);
		}

		private function in_hidden($str)
		{
			$segs = explode('/', $str);
			return is_dir($str) && $segs[count($segs)-1][0] == '.';
		}
		private function in_folders($str)
		{
			$segs = explode('/', $str);
			return is_dir($str) && $segs[count($segs)-1][0] != '.';
		}

		public function getFolders() { return array_filter($this->content, array($this,'in_folders')); }

		public function getHidden() { return $this->hidden; }

		public function getContent() { return $this->content; }

		public function getFiles() { return array_filter($this->content, 'is_file'); }

		public function getDir() { return $this->dir; }
	}
?>