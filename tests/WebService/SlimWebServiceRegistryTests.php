<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/external/Slim/Slim.php');
require_once(ROOT_DIR . 'lib/WebService/Slim/namespace.php');

class TestSlimCall
{
	public $route;
	public $callback;

	public function __construct($route, $callback)
	{
		$this->route = $route;
		$this->callback = $callback;
	}
}

class TestSlim extends Slim\Slim
{
	public $gets = array();
	public $posts = array();

	public function __construct()
	{

	}

	public function get($route, $callback)
	{
		$this->gets[] = new TestSlimCall($route, $callback);
	}

	public function post($route, $callback)
	{
		$this->posts[] = new TestSlimCall($route, $callback);
	}
}



class SlimWebServiceRegistryTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testRegistersCategoryWithSlim()
	{
		$callback = array($this, 'cb');

		$slim = new TestSlim();

		$registry = new SlimWebServiceRegistry($slim);

		$c1Name = 'Something';
		$c2Name = 'SomethingElse';

		$category1 = new SlimWebServiceRegistryCategory($c1Name);
		$category2 = new SlimWebServiceRegistryCategory($c2Name);

		$c1p1 = '/post/1/';
		$c1p2 = '/get/:1';

		$c2p1 = 'post/2/';
		$c2p2 = 'get/:2';


		$category1->AddPost($c1p1, $callback);
		$category1->AddGet($c1p2, $callback);

		$category2->AddPost($c2p1, $callback);
		$category2->AddGet($c2p2, $callback);

		$registry->AddCategory($category1);
		$registry->AddCategory($category2);

		$this->assertEquals('Something/post/1', $slim->posts[0]->route);
		$this->assertEquals($callback, $slim->posts[0]->callback);
		$this->assertEquals('Something/get/:1', $slim->gets[0]->route);
		$this->assertEquals($callback, $slim->gets[0]->callback);

		$this->assertEquals('SomethingElse/post/2', $slim->posts[1]->route);
		$this->assertEquals($callback, $slim->posts[1]->callback);
		$this->assertEquals('SomethingElse/get/:2', $slim->gets[1]->route);
		$this->assertEquals($callback, $slim->gets[1]->callback);
	}

	private function cb()
	{
	}
}

?>