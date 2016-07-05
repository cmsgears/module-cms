<?php
namespace cmsgears\cms\common\components;

// Yii Imports
use \Yii;
use yii\di\Container;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class Cms extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

    /**
     * Initialise the CMG Core Component.
     */
    public function init() {

        parent::init();

		// Register application components and objects i.e. CMG and Project
		$this->registerComponents();
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Cms -----------------------------------

	// Properties

	// Components and Objects

	public function registerComponents() {

		// Init system services
		$this->initSystemServices();

		// Register services
		$this->registerResourceServices();
		$this->registerMapperServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initMapperServices();
		$this->initEntityServices();
	}

	public function initSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( '<name>', '<classpath>' );
	}

	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( 'cmsgears\core\common\services\interfaces\resources\IAddressService', 'cmsgears\core\common\services\resources\AddressService' );
	}

	public function registerMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( 'cmsgears\core\common\services\interfaces\mappers\IModelAddressService', 'cmsgears\core\common\services\mappers\ModelAddressService' );
	}

	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( 'cmsgears\core\common\services\interfaces\entities\ICountryService', 'cmsgears\core\common\services\entities\CountryService' );
	}

	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( 'addressService', 'cmsgears\core\common\services\resources\AddressService' );
	}

	public function initMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( 'modelAddressService', 'cmsgears\core\common\services\mappers\ModelAddressService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( 'countryService', 'cmsgears\core\common\services\entities\CountryService' );
	}
}

?>