<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Article;
use dektrium\user\models\User;

class InitController extends Controller
{
	private $auth = null;
	private $adminID = null;
	
    public function actionInit()
	{
		$this->auth = Yii::$app->authManager;
		if (!$this->auth)
			return false;
		$this->createRoles();
		$this->createAdminUser();
		$this->populateArticles();
	}
	
	public function actionRoles()
	{
		return $this->createRoles();
	}
	
	public function actionAdmin()
	{
		return $this->createAdminUser();
	}
	
	public function actionArticles()
	{
		return $this->createArticles();
	}

	private function createAdminUser()
	{
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);
        $user->load(['User' => ['username' => 'admin1', 'email' => 'admin@yourdomain.com', 'password' => 'admin12']]);
		if (!$user->create()) 
			return false;
		
		$this->adminID = $user->getId();
		$this->auth->assign($this->auth->getRole('admin'), $this->adminID);
	}
	
	private function createRoles()
    {
        // add "viewArticles" permission
        $viewArticles = $this->auth->createPermission('viewArticles');
        $viewArticles->description = 'View Article';
        $this->auth->add($viewArticles);

        // add "manageArticles" permission
        $manageArticles = $this->auth->createPermission('manageArticles');
        $manageArticles->description = 'Manage Acticle';
        $this->auth->add($manageArticles);

        // add "adminPermission" permission
        $adminPermission = $this->auth->createPermission('adminPermission');
        $adminPermission->description = 'Manage Users';
        $this->auth->add($adminPermission);

        // add "auth_user" role and give this role the "viewArticles" permission
        $auth_user = $this->auth->createRole('auth_user');
		$auth_user->description = "Authenticated user";
        $this->auth->add($auth_user);
        $this->auth->addChild($auth_user, $viewArticles);

        // add "moderator" role and give this role the "manageArticles" permission
        // as well as the permissions of the "author" role
        $moderator = $this->auth->createRole('moderator');
		$moderator->description = "Moderator";
        $this->auth->add($moderator);
        $this->auth->addChild($moderator, $manageArticles);
        $this->auth->addChild($moderator, $auth_user);

        // add "admin" role and give this role the "manageUsers" permission
        // as well as the permissions of the "moderator" role
        $admin = $this->auth->createRole('admin');
		$admin->description = "Administrator";
        $this->auth->add($admin);
        $this->auth->addChild($admin, $adminPermission);
        $this->auth->addChild($admin, $moderator);
    }
	
	private function populateArticles()
	{
		$data = [ 'Article' => [
			'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
			'intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',	
			'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
			'status' => 10,
//			'author' => $this->adminID,
			'author' => 1,
			],
		];
		for ($i = 0; $i < 25; $i++) {
			$model = new Article();
			$model->load($data);
			$model->save();
		}
	}
}