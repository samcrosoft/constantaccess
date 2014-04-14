<?php
class ConstantAccessTest extends PHPUnit_Framework_TestCase
{
    protected $oConstantAccess = null;

    protected function setUp()
    {
        $this->oConstantAccess = new Constants;
        //or
        //$this->oConstantAccess = new ConstantAccess\ConstantAccess;
    }

    /*
    public function testConstantsObjectIsCountable()
    {
        $this->oConstantAccess->ConstTrial = 23;
        $this->assertCount(1, $this->oConstantAccess);
    }
    */

    public function testConstantsDefinedByArray()
    {
        $aTest = array(
                        'CONST1'=>1,
                        'CONST2'=>2
                      );
        $this->oConstantAccess = new \ConstantAccess\ConstantAccess($aTest);
        $this->assertTrue(defined('CONST1'), 'Constants [CONST1] has not been defined');
        $this->assertEquals(constant('CONST1'), 1);
        $this->assertTrue(defined('CONST2'), 'Constants [CONST2] has not been defined');
        $this->assertEquals(constant('CONST2'), 2);
    }

    public function testIfOnlyValidConstantKeysAreAllowed()
    {
        $this->assertTrue($this->oConstantAccess->isKeySuitableForConstant('string'), "The key 'String' should be valid for a constant key");
        $this->assertTrue($this->oConstantAccess->isKeySuitableForConstant('_string'), "The key '_string' should be valid for a constant key");
        $this->assertFalse($this->oConstantAccess->isKeySuitableForConstant('22string'), "The key '22string' should NOT be valid for a constant key");
        $this->assertFalse($this->oConstantAccess->isKeySuitableForConstant(null), "The key null should NOT be valid for a constant key");
    }

    public function testIfThrowExceptionOnWrongValue()
    {
        $this->setExpectedException('ConstantAccess\Exceptions\ConstantsException', ConstantAccess\Data\ConstantsData::EXCEPTION_MESSAGE_INVALID_VALUE);
        $this->oConstantAccess->setThrowException(true);
        $this->oConstantAccess->testConstant = array();
    }

    public function testConstantsAccessImplementsNecessaryClasses()
    {
        $this->assertTrue($this->oConstantAccess instanceof ConstantAccess\Data\ConstantsData);
        $this->assertTrue($this->oConstantAccess instanceof Countable);
        $this->assertTrue($this->oConstantAccess instanceof ArrayAccess);

    }


    /**
     * @dataProvider defaultReturnValueDataProvider
     */
    public function testUndefinedConstantReturnsDefaultReturnValue($mValue, $mExpected)
    {
        // assert that it is null by default
        $this->assertEquals(null, $this->oConstantAccess->undefinedConstant);

        $this->oConstantAccess->setValueReturnIfNotDefined($mValue);
        $this->assertEquals($this->oConstantAccess->getValueReturnIfNotDefined(), $mExpected);
        $this->assertEquals($this->oConstantAccess->undefinedConstantAgain, $mExpected);
    }

    public function testConstantArrayAccess()
    {
        $this->oConstantAccess['trial'] = 22;
        $this->assertEquals(constant('trial'),22);
        $this->assertEquals($this->oConstantAccess['trial'],22);
    }

    public function defaultReturnValueDataProvider()
    {
        $aData = array(
            array(false, false),
            array(true, true),
            array(1, 1),
            array(2, 2),
            array('string', 'string')
        );

        return $aData;
    }

    protected function tearDown()
    {
        $this->oConstantAccess = null;
    }
}
