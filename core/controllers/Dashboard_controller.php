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
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'switch_account')
			{
				$query = $this->model->get_session($_POST['id']);

				if (!empty($query))
				{
					Session::set_value('vkye_account', $query['account']);
					Session::set_value('vkye_user', $query['user']);
					Session::set_value('vkye_lang', $query['user']['language']);
					Session::set_value('vkye_temporal', []);

					echo json_encode([
						'status' => 'success'
					]);
				}
				else
				{
					echo json_encode([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}

			if ($_POST['action'] == 'logout')
			{
				Session::destroy();

				echo json_encode([
					'status' => 'success'
				]);
			}
		}
		else
		{
			define('_title', Configuration::$web_page . ' | {$lang.dashboard}');

			$template = $this->view->render($this, 'index');

			echo $template;
		}
	}
}
