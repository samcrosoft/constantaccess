<?php
namespace Samcrosoft\ConstantAccess;

use Samcrosoft\ConstantAccess\Exceptions as AccessExceptions;
use Samcrosoft\ConstantAccess\Data as DataAccess;

/**
 * Class ConstantAccess
 * @package Samcrosoft\ConstantAccess
 */
class ConstantAccess extends DataAccess\ConstantsData implements
    \Countable,
    \ArrayAccess
{
    /**
     * This variable determines if exceptions should be thrown or not
     * @var bool
     */
    private $bThrowExceptions = false;

    /**
     * This variable is what is returned by the handleExceptionThrowing if the $bThrowExceptions has been set to false;
     * @var bool
     */
    private $mExceptionFallbackValue;

    /**
     * This is the variable to return if the requested constant is not defined
     * @see __get
     * @var null
     */
    private $mReturnIfNotDefined;

    /**
     * This sets the value that is returned if the constant requested does not exist and $bThrowExceptions has been set to false
     * @param null $mReturnIfNotDefined
     */
    public function setValueReturnIfNotDefined($mReturnIfNotDefined)
    {
        $this->mReturnIfNotDefined = $mReturnIfNotDefined;
    }

    /**
     * This refers to the value returned if the requested constant does not exist
     * @return mixed
     */
    public function getValueReturnIfNotDefined()
    {
        return $this->mReturnIfNotDefined;
    }


    /**
     * This is the constructor that initiates a new object of the constant access class
     * @param array $aValues
     * @param bool $bExceptionFallback
     * @param null|mixed $mReturnIfNotDefinedValue
     */
    public function __construct($aValues = array(), $bExceptionFallback = false, $mReturnIfNotDefinedValue = null)
    {
        $bExceptionFallback = is_bool($bExceptionFallback) ? $bExceptionFallback : false;

        // set the exception fallback value to false
        $this->setExceptionFallbackValue($bExceptionFallback);
        // set the default return if not defined value to null
        $this->setValueReturnIfNotDefined($mReturnIfNotDefinedValue);

        // if the supplied value is an array, then create constants from it
        if (!($this->isArrayMulti($aValues))) {
            $this->setArrayToConstant($aValues);
        }
    }

    /**
     * This method tests if the passed parameter is an array or not
     * @param array $aVal
     * @return bool
     */
    private function isArrayMulti($aVal = null)
    {
        if (!is_array($aVal) || empty($aVal))
            return false;

        $rv = array_filter($aVal, 'is_array');
        if (count($rv) > 0) return true;
        return false;
    }

    /**
     * This method creates a group of constants from an array
     * @param array $aVal
     * @access protected
     */
    protected function setArrayToConstant(array $aVal)
    {
        foreach ($aVal as $sKey => $sVal):
            $this->__set($sKey, $sVal);
        endforeach;
    }


    /**
     * This method maps the supplied category to the array key for use in the  get_defined_constants method
     * @access private
     * @param string $sCategory
     * @see get_defined_constants
     * @return null|string
     */
    private function getCategoryMapping($sCategory = self::CONSTANTS_USER_CATEGORY)
    {
        $sRetCat = null;

        if (array_key_exists($sCategory, $this->aCategoriesMappings)) {
            $sRetCat = is_string($this->aCategoriesMappings[$sCategory]) ? $this->aCategoriesMappings[$sCategory] : $sRetCat;
        }

        return $sRetCat;
    }

    /**
     * Implements and overloads the count method of the Countable Interface and it makes it filterable to suit the purpose
     * @access public
     * @param string $sCategory
     * @see Countable::count()
     * @return int
     */
    public function count($sCategory = self::CONSTANTS_USER_CATEGORY)
    {

        // $iVal 	 		= 0;
        // get the defined constants
        $aReturn = get_defined_constants(true);
        // get the constant mapping
        $sRetCategory = $this->getCategoryMapping($sCategory);


        if (is_string($sRetCategory)) {
            $iVal = (isset($aReturn[$sRetCategory]) && is_array($aReturn[$sRetCategory])) ? count($aReturn[$sRetCategory]) : 0;
        } else {
            $iVal = count($aReturn, COUNT_RECURSIVE);
        }

        return $iVal;
    }


    /**
     * This returns the number of core constants available in php
     * @return number
     */
    public function countCoreConstants()
    {
        return $this->count(self::CONSTANTS_CORE_CATEGORY);
    }

    /**
     * This method returns the value of the throw exceptions property. It helps in deciding if the code should throw exception or not
     * @access public
     * @uses $this->bThrowException
     * @return boolean
     */
    public function getThrowException()
    {
        return (bool)$this->bThrowExceptions;
    }

    /**
     * This method sets the value of the throw exceptions property. It helps in deciding if the code should throw exception or not
     * @access public
     * @param bool $bValue
     */
    public function setThrowException($bValue = false)
    {
        $this->bThrowExceptions = (is_bool($bValue)) ? $bValue : false;
    }

    /**
     * Overrides the __get magic method to allow a constant to be accessed as a propery of the instance of this class
     * @param string $sName
     * @return mixed|NULL
     */
    public function __get($sName)
    {
        if (property_exists($this, $sName)) {
            return $this->{$sName};
        } elseif (defined($sName)) {
            return constant($sName);
        } else {
            return $this->getValueReturnIfNotDefined();
        }
    }

    /**
     * This method certifies if a supplied value is safe for use in defining a constant
     * Only NULL or Scalar variables (integer, float, string or boolean) are considered safe
     * @param null|mixed $mValue
     * @return bool
     */
    public function isValueSuitableForConstant($mValue = NULL)
    {
        $bConsiderSafe = false;
        if (is_null($mValue) || is_int($mValue) || is_string($mValue) || is_float($mValue) || is_bool($mValue)) {
            $bConsiderSafe = true;
        } else {
            $this->handleExceptionThrowing(self::EXCEPTION_MESSAGE_INVALID_VALUE);
        }

        return $bConsiderSafe;
    }

    /**
     * This tests if a variable is suitable for use as a constant key
     * @param string $sKey
     * @return bool
     */
    public function isKeySuitableForConstant($sKey = "")
    {
        $bReturn = false;
        if (preg_match(self::VALID_VARIABLE_REGEX_PATTERN, $sKey)) {
            $bReturn = true;
        }

        return $bReturn;
    }

    /**
     * @param string $sMessage - Message of the exception to throw
     * @param \Exception $oException If set, this represents the exception to throw and this would be used instead of creating a new exception
     * @throws Exceptions\ConstantsException
     * @throws \Exception
     * @internal param bool $mFallbackReturn - Fallback value to return, if the class has been configured not to throw exceptions
     * @return bool
     */
    private function handleExceptionThrowing($sMessage = "", \Exception $oException = null)
    {
        if ($this->getThrowException()) {
            // php 5.3 here
            if (!is_null($oException) && class_exists($oException) && is_subclass_of($oException, "Exception")) {
                throw $oException;
            } else {
                throw new AccessExceptions\ConstantsException($sMessage);
            }
        } else {
            return $this->getExceptionFallbackValue();
        }
    }


    /**
     * This method overloads the __set function of the constants class
     * @param string $sKey
     * @param mixed $mValue
     * @return mixed|boolean
     */
    public function __set($sKey, $mValue = NULL)
    {
        if (defined($sKey)) {
            return $this->handleExceptionThrowing(self::EXCEPTION_MESSAGE_CONSTANT_DEFINED);
        } elseif (!($this->isKeySuitableForConstant($sKey))) {
            return $this->handleExceptionThrowing(self::EXCEPTION_MESSAGE_INVALID_KEY);
        } elseif ($this->isValueSuitableForConstant($mValue)) {
            define($sKey, $mValue);
            return true;
        } else {
            return false;
        }

    }


    /**
     * @param mixed $mValue
     */
    public function setExceptionFallbackValue($mValue)
    {
        $this->mExceptionFallbackValue = $mValue;
    }

    /**
     * @return mixed
     */
    public function getExceptionFallbackValue()
    {
        return $this->mExceptionFallbackValue;
    }


    /**
     * This is an overload of the offsetExists from the ArrayAccessInterface
     * @param string $sOffset
     * @see ArrayAccess::offsetExists()
     * @return bool
     */
    public function offsetExists($sOffset)
    {
        if (empty($sOffset) && !is_string($sOffset)) {
            $bExists = false;
        } elseif (defined($sOffset)) {
            $bExists = true;
        } else {
            $bExists = false;
        }

        return $bExists;
    }


    /**
     * This is an overload of the offsetGet from the ArrayAccessInterface
     * Null is returned if the offset is not available
     * @param string $sOffset
     * @see ArrayAccess::offsetGet()
     * @see __get
     * @return mixed|NULL
     */
    public function offsetGet($sOffset)
    {
        if ($this->offsetExists($sOffset)) {
            return $this->__get($sOffset);
        }

        return $this->getValueReturnIfNotDefined();
    }


    /**
     * This is an overload of the offsetSet from the ArrayAccessInterface
     * @param string $offset
     * @param mixed $value
     * @see ArrayAccess::offsetSet()
     * @see __set
     * @return mixed|null
     */
    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        // a constant cannot be undefined or deleted, so this will just be left unattended to
    }


}