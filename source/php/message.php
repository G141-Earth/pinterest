<?php
abstract class Message
{
	protected $error = false;
	protected $message = "";
	
	function __construct()
	{
		# code...
	}

	public function setError(string $message)
	{
		$this->message = $message;
		$this->error = true;
	}

	public function getMessage() : string
	{
		return $this->message;
	}

	public function is_success() : bool
	{
		return !$this->error;
	}

	abstract public function setObject($object);

	abstract public function getObject();
}
?>