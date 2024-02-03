<?php

declare(strict_types=1);

namespace Up\Controllers;

use Exception;
use Up\Services\AuthenticationService;
use Up\Services\Repository\ProductService;
use Up\Services\Repository\UserService;

class AdminController extends BaseController
{
	/**
	 * @throws Exception
	 */
	public function adminAction($id): string
	{
		session_start();
		if (isset($_SESSION['AdminEmail']))
		{
			$products = ProductService::getProductListForAdmin();
			$user = UserService::getUserByEmail($_SESSION['AdminEmail']);

			return $this->render('layout', [
				'modal' => $this->render('/components/modals', []),
				'page' => $this->render('/pages/admin', [
					'id' => $id,
					'adminFullName' => $user->name . ' ' . $user->surname,
					'adminEmail' => $user->email,
					'content' => $this->render('/components/admin-list', ['products' => $products]),
					'adminEdit' => $this->render('/components/admin-edit', []),
				]),
			]);
		}
		else
		{
			header('Location: /login/');
		}
	}

	/**
	 * @throws Exception
	 */
	public function loginAction()
	{
		session_start();
		$error = $_SESSION['AuthError'] ?? '';
		return $this->render('layout', [
			'modal' => $this->render('/components/modals', []),
			'page' => $this->render('/pages/login', [
				'error' => $error ,
			]),
		]);

	}
}

