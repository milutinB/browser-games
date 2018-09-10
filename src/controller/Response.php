<?php
class Response {

	private $content;
	private $type;
	private $data;

	public function __construct( $content, $type, $data ) {

		$this->type = $type;

		$this->content = $content;

		$this->data = $data;

	}

	public function send() {

		if ( $this->type == 'json' ) {

			header('Content-Type: application/json');

			echo json_encode($this->data);

		} else if ( $this->type == 'page' ) {

			$data = $this->data;

			include $this->content;

		} else if ($this->type == 'redirect') {

			header('Location: ' . $this->content);
			die();

		} else if ( $this->type == 'logout' ) {

			session_destroy();
			header('Location: /');
			die();

		}

	}

}
