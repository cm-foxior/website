<?php

defined('_EXEC') or die;

class Products_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($params)
	{
		global $data;

		if ($params[0] == 'salemenu')
			$data['type'] = 'sale_menu';
		else if ($params[0] == 'supplies')
			$data['type'] = 'supply';
		else if ($params[0] == 'recipes')
			$data['type'] = 'recipe';
		else if ($params[0] == 'workmaterial')
			$data['type'] = 'work_material';

		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'create_product' OR $_POST['action'] == 'update_product')
			{
				$errors = [];

				if (Validations::empty($_POST['name']) == false)
					array_push($errors, ['name','{$lang.dont_leave_this_field_empty}']);

				if ($data['type'] == 'sale_menu' OR $data['type'] == 'supply' OR $data['type'] == 'work_material')
				{
					if (Validations::empty($_POST['token']) == false)
						array_push($errors, ['token','{$lang.dont_leave_this_field_empty}']);
					else if (Validations::string(['uppercase','lowercase','int'], $_POST['token']) == false)
						array_push($errors, ['token','{$lang.invalid_field}']);
				}

				if ($data['type'] == 'sale_menu' OR $data['type'] == 'supply' OR $data['type'] == 'work_material')
				{
					if (Validations::empty($_POST['storage_unity']) == false)
						array_push($errors, ['storage_unity','{$lang.dont_leave_this_field_empty}']);
				}

				if ($data['type'] == 'sale_menu')
				{
					if (Validations::empty($_POST['price']) == false)
						array_push($errors, ['price','{$lang.dont_leave_this_field_empty}']);
					else if (Validations::number('float', $_POST['price']) == false)
						array_push($errors, ['price','{$lang.invalid_field}']);

					if (Validations::empty([$_POST['gain_margin_amount'],$_POST['gain_margin_type']]) == false)
						array_push($errors, ['gain_margin_amount','{$lang.dont_leave_this_field_empty}']);
					else if (Validations::number('float', $_POST['gain_margin_amount'], true) == false)
						array_push($errors, ['gain_margin_amount','{$lang.invalid_field}']);
				}

				if ($data['type'] == 'sale_menu' OR $data['type'] == 'supply')
				{
					if (Validations::number('float', $_POST['weight_full'], true) == false)
						array_push($errors, ['weight_full','{$lang.invalid_field}']);

					if (Validations::number('float', $_POST['weight_empty'], true) == false)
						array_push($errors, ['weight_empty','{$lang.invalid_field}']);
				}

				if (empty($errors))
				{
					if ($data['type'] == 'sale_menu')
						$_POST['avatar'] = $_FILES['avatar'];

					$_POST['type'] = $data['type'];

					if ($_POST['action'] == 'create_product')
						$query = $this->model->create_product($_POST);
					else if ($_POST['action'] == 'update_product')
						$query = $this->model->update_product($_POST);

					if (!empty($query))
					{
						echo json_encode([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
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
				else
				{
					echo json_encode([
						'status' => 'error',
						'errors' => $errors
					]);
				}
			}

			if ($_POST['action'] == 'read_product')
			{
				$query = $this->model->read_product($_POST['id']);

				if (!empty($query))
				{
					echo json_encode([
						'status' => 'success',
						'data' => $query
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

			if ($_POST['action'] == 'block_product' OR $_POST['action'] == 'unblock_product' OR $_POST['action'] == 'delete_product')
			{
				if ($_POST['action'] == 'block_product')
					$query = $this->model->block_product($_POST['id']);
				else if ($_POST['action'] == 'unblock_product')
					$query = $this->model->unblock_product($_POST['id']);
				else if ($_POST['action'] == 'delete_product')
					$query = $this->model->delete_product($_POST['id']);

				if (!empty($query))
				{
					echo json_encode([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
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
		}
		else
		{
			define('_title', Configuration::$web_page . ' | {$lang.products} | {$lang.' . $params[0] . '}');

			$data['products'] = $this->model->read_products($data['type']);
			$data['products_unities'] = $this->model->read_products_unities(true);
			$data['products_categories'] = $this->model->read_products_categories(true);
			// $data['products_supplies'] = $this->model->read_products('supply', true);
			// $data['products_recipes'] = $this->model->read_products('recipe', true);

			$template = $this->view->render($this, 'index');

			echo $template;
		}
	}

	public function categories()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'create_product_category' OR $_POST['action'] == 'update_product_category')
			{
				$errors = [];

				if (Validations::empty($_POST['name']) == false)
					array_push($errors, ['name','{$lang.dont_leave_this_field_empty}']);

				if (Validations::empty($_POST['level']) == false)
					array_push($errors, ['level','{$lang.dont_leave_this_field_empty}']);
				else if (Validations::number('int', $_POST['level']) == false)
					array_push($errors, ['level','{$lang.invalid_field}']);

				if (empty($errors))
				{
					if ($_POST['action'] == 'create_product_category')
						$query = $this->model->create_product_category($_POST);
					else if ($_POST['action'] == 'update_product_category')
						$query = $this->model->update_product_category($_POST);

					if (!empty($query))
					{
						echo json_encode([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
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
				else
				{
					echo json_encode([
						'status' => 'error',
						'errors' => $errors
					]);
				}
			}

			if ($_POST['action'] == 'read_product_category')
			{
				$query = $this->model->read_product_category($_POST['id']);

				if (!empty($query))
				{
					echo json_encode([
						'status' => 'success',
						'data' => $query
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

			if ($_POST['action'] == 'block_product_category' OR $_POST['action'] == 'unblock_product_category' OR $_POST['action'] == 'delete_product_category')
			{
				if ($_POST['action'] == 'block_product_category')
					$query = $this->model->block_product_category($_POST['id']);
				else if ($_POST['action'] == 'unblock_product_category')
					$query = $this->model->unblock_product_category($_POST['id']);
				else if ($_POST['action'] == 'delete_product_category')
					$query = $this->model->delete_product_category($_POST['id']);

				if (!empty($query))
				{
					echo json_encode([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
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
		}
		else
		{
			define('_title', Configuration::$web_page . ' | {$lang.products} | {$lang.categories}');

			global $data;

			$data['products_categories'] = $this->model->read_products_categories();

			$template = $this->view->render($this, 'categories');

			echo $template;
		}
	}

	public function unities()
	{
		if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'create_product_unity' OR $_POST['action'] == 'update_product_unity')
			{
				$errors = [];

				if (Validations::empty($_POST['name']) == false)
					array_push($errors, ['name','{$lang.dont_leave_this_field_empty}']);

				if (empty($errors))
				{
					if ($_POST['action'] == 'create_product_unity')
						$query = $this->model->create_product_unity($_POST);
					else if ($_POST['action'] == 'update_product_unity')
						$query = $this->model->update_product_unity($_POST);

					if (!empty($query))
					{
						echo json_encode([
							'status' => 'success',
							'message' => '{$lang.operation_success}'
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
				else
				{
					echo json_encode([
						'status' => 'error',
						'errors' => $errors
					]);
				}
			}

			if ($_POST['action'] == 'read_product_unity')
			{
				$query = $this->model->read_product_unity($_POST['id']);

				if (!empty($query))
				{
					echo json_encode([
						'status' => 'success',
						'data' => $query
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

			if ($_POST['action'] == 'block_product_unity' OR $_POST['action'] == 'unblock_product_unity' OR $_POST['action'] == 'delete_product_unity')
			{
				if ($_POST['action'] == 'block_product_unity')
					$query = $this->model->block_product_unity($_POST['id']);
				else if ($_POST['action'] == 'unblock_product_unity')
					$query = $this->model->unblock_product_unity($_POST['id']);
				else if ($_POST['action'] == 'delete_product_unity')
					$query = $this->model->delete_product_unity($_POST['id']);

				if (!empty($query))
				{
					echo json_encode([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
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
		}
		else
		{
			define('_title', Configuration::$web_page . ' | {$lang.products} | {$lang.unities}');

			global $data;

			$data['products_unities'] = $this->model->read_products_unities();

			$template = $this->view->render($this, 'unities');

			echo $template;
		}
	}
}
