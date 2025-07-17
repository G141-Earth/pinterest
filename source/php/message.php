<?php
abstract class Message
{
	protected bool $error = false;
	protected string $message = "";
	
	function __construct()
	{
		# code...
	}

	public function setError(string $message) : void
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