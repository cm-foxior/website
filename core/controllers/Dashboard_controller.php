<?php

defined('_EXEC') or die;

class Dashboard_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		define('_title', '{$lang.title}');

		$template = $this->view->render($this, 'index');
        $template = $this->format->replaceFile($template, 'header');

		if (Session::getValue('level') == 10 OR Session::getValue('level') == 9 OR Session::getValue('level') == 7)
			header('Location: /pointsale/add');
		else if (Session::getValue('level') == 8)
			header('Location: /inventories');

		echo $template;
	}
}
