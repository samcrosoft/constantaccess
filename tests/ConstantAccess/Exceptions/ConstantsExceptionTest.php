<?php
namespace Samcrosoft\ConstantAccessTest\Exceptions;
use Exception;
use PHPUnit_Framework_TestCase;
use Samcrosoft\ConstantAccess\Exceptions\ConstantsException;

/**
 * Class ConstantsExceptionTest
 * @package Samcrosoft\ConstantAccessTest\Exceptions
 */
class ConstantsExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConstantsException
     */
    protected $oExceptions;

    const sExceptionMessage = "test message";

    const iExceptionCode    = 2;

    public function setUp()
    {
        $this->oExceptions = new ConstantsException(self::sExceptionMessage, self::iExceptionCode);
    }

    public function testConstantExceptionIsInstanceofException()
    {
        $this->assertTrue(($this->oExceptions instanceof Exception), "Constant Exception Is Not An Instance Of Exception");
        $this->assertTrue(($this->oExceptions instanceof ConstantsException), "Constant Exception Is Not An Instance Of Constants Exception");
    }


    public function testConstantExceptionMessageIsValid()
    {
        $this->assertTrue(is_string($this->oExceptions->getMessage()),"Exception getMessage Is Not Returning String");
        $this->assertEquals($this->oExceptions->getMessage(), self::sExceptionMessage, 'Exception getMessage Returns Invalid Message');
    }

    public function testConstantExceptionCodeIsValid()
    {
        $this->assertTrue(is_integer($this->oExceptions->getCode()),"Exception getCode Is Not Returning Integer");
        $this->assertEquals($this->oExceptions->getCode(), self::iExceptionCode, "Exception getCode Returns Incorrect Code");
    }


    public function tearDown()
    {
        $this->oExceptions = null;
    }
}
