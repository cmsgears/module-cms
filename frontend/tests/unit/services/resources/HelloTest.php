<?php

namespace cmsgears\cms\frontend\tests\unit\services\resources;

//use common\fixtures\UserFixture;
//use common\models\entities\CashbackActivity;
/**
 * Login form test
 */
class HelloTest extends \Codeception\Test\Unit
{
	public function testHello(){
		
		expect( "hello", true )->true();
	}
}