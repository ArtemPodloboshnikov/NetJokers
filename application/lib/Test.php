<?php 
	
	use application\lib\PHPUnit;
	use application\models\Main;

	class Test extends PHPUnit_TestCase
	{
		
		public function testGetDataOfProfile()
		{
			$mainModel = new Main();
			$data = $mainModel->getDataOfProfile('a48e1581-74d7-4bdd-ab3d-04e8c8160b5e');
			$this->assertEmpty($data);
		}
	}


 ?>