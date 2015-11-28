<?php
namespace Samcrosoft\ConstantAccess\Data;

/**
 * Class ConstantsData
 * @package Samrosoft\ConstantAccess\Data
 */
class ConstantsData {
	
	const CONSTANTS_USER_CATEGORY 			= "CONSTANTS_USER_CATEGORY";
	const CONSTANTS_CORE_CATEGORY 			= "CONSTANTS_CORE_CATEGORY";
	const CONSTANTS_CALENDAR_CATEGORY 		= "CONSTANTS_CALENDAR_CATEGORY";
	const CONSTANTS_COM_DOTNET_CATEGORY 	= "CONSTANTS_COM_DOTNET_CATEGORY";
	const CONSTANTS_DATE_CATEGORY 			= "CONSTANTS_DATE_CATEGORY";
	const CONSTANTS_FILTER_CATEGORY 		= "CONSTANTS_FILTER_CATEGORY";
	const CONSTANTS_FTP_CATEGORY 			= "CONSTANTS_FTP_CATEGORY";
	const CONSTANTS_HASH_CATEGORY 			= "CONSTANTS_HASH_CATEGORY";
	const CONSTANTS_ICONV_CATEGORY 			= "CONSTANTS_ICONV_CATEGORY";
	const CONSTANTS_JSON_CATEGORY 			= "CONSTANTS_JSON_CATEGORY";
	const CONSTANTS_MCRYPT_CATEGORY 		= "CONSTANTS_MCRYPT_CATEGORY";
	const CONSTANTS_ODBC_CATEGORY 			= "CONSTANTS_ODBC_CATEGORY";
	const CONSTANTS_PCRE_CATEGORY 			= "CONSTANTS_PCRE_CATEGORY";
	const CONSTANTS_STANDARD_CATEGORY 		= "CONSTANTS_STANDARD_CATEGORY";
	const CONSTANTS_TOKENIZER_CATEGORY 		= "CONSTANTS_TOKENIZER_CATEGORY";
	const CONSTANTS_ZLIB_CATEGORY 			= "CONSTANTS_ZLIB_CATEGORY";
	const CONSTANTS_LIBXML_CATEGORY 		= "CONSTANTS_LIBXML_CATEGORY";
	const CONSTANTS_DOM_CATEGORY 			= "CONSTANTS_DOM_CATEGORY";
	const CONSTANTS_XML_CATEGORY 			= "CONSTANTS_XML_CATEGORY";
	const CONSTANTS_OPENSSL_CATEGORY 		= "CONSTANTS_OPENSSL_CATEGORY";
	const CONSTANTS_CURL_CATEGORY 			= "CONSTANTS_CURL_CATEGORY";
	const CONSTANTS_GD_CATEGORY 			= "CONSTANTS_GD_CATEGORY";
	const CONSTANTS_GMP_CATEGORY 			= "CONSTANTS_GMP_CATEGORY";
	const CONSTANTS_IMAP_CATEGORY 			= "CONSTANTS_IMAP_CATEGORY";
	const CONSTANTS_MBSTRING_CATEGORY 		= "CONSTANTS_MBSTRING_CATEGORY";
	const CONSTANTS_MYSQL_CATEGORY 			= "CONSTANTS_MYSQL_CATEGORY";
	const CONSTANTS_SOAP_CATEGORY 			= "CONSTANTS_SOAP_CATEGORY";
	const CONSTANTS_SOCKETS_CATEGORY 		= "CONSTANTS_SOCKETS_CATEGORY";
	const CONSTANTS_SQLITE3_CATEGORY 		= "CONSTANTS_SQLITE3_CATEGORY";
	const CONSTANTS_TIDY_CATEGORY 			= "CONSTANTS_TIDY_CATEGORY";
	const CONSTANTS_EXIF_CATEGORY 			= "CONSTANTS_EXIF_CATEGORY";
	const CONSTANTS_XHPROF_CATEGORY 		= "CONSTANTS_XHPROF_CATEGORY";
	const CONSTANTS_XDEBUG_CATEGORY 		= "CONSTANTS_XDEBUG_CATEGORY";
	
	
	
	
	/**
	 *
	 * This variable holds the mappings of the constants to the string value that represents keys of the get_defined_constants array
	 * @var array $aCategoriesMappings
	 * @access protected
	 */
	protected $aCategoriesMappings 			= array( 	self::CONSTANTS_USER_CATEGORY 			=> 'user',
														self::CONSTANTS_CORE_CATEGORY 			=> 'Core',
														self::CONSTANTS_CALENDAR_CATEGORY 		=> 'calendar',
														self::CONSTANTS_COM_DOTNET_CATEGORY 	=> 'com_dotnet',
														self::CONSTANTS_DATE_CATEGORY  			=> "date",
														self::CONSTANTS_FILTER_CATEGORY 		=> "filter",
														self::CONSTANTS_FTP_CATEGORY 			=> "ftp",
														self::CONSTANTS_HASH_CATEGORY 			=> "hash",
														self::CONSTANTS_ICONV_CATEGORY 			=> "iconv",
														self::CONSTANTS_JSON_CATEGORY 			=> "json",
														self::CONSTANTS_MCRYPT_CATEGORY 		=> "mcrypt",
														self::CONSTANTS_ODBC_CATEGORY 			=> "odbc",
														self::CONSTANTS_PCRE_CATEGORY 			=> "pcre",
														self::CONSTANTS_STANDARD_CATEGORY 		=> "standard",
														self::CONSTANTS_TOKENIZER_CATEGORY 		=> "tokenizer",
														self::CONSTANTS_ZLIB_CATEGORY 			=> "zlib",
														self::CONSTANTS_LIBXML_CATEGORY 		=> "libxml",
														self::CONSTANTS_DOM_CATEGORY 			=> "dom",
														self::CONSTANTS_XML_CATEGORY 			=> "xml",
														self::CONSTANTS_OPENSSL_CATEGORY 		=> "openssl",
														self::CONSTANTS_CURL_CATEGORY 			=> "curl",
														self::CONSTANTS_GD_CATEGORY 			=> "gd",
														self::CONSTANTS_GMP_CATEGORY 			=> "gmp",
														self::CONSTANTS_IMAP_CATEGORY 			=> "imap",
														self::CONSTANTS_MBSTRING_CATEGORY 		=> "mbstring",
														self::CONSTANTS_MYSQL_CATEGORY 			=> "mysql",
														self::CONSTANTS_SOAP_CATEGORY 			=> "soap",
														self::CONSTANTS_SOCKETS_CATEGORY 		=> "sockets",
														self::CONSTANTS_SQLITE3_CATEGORY 		=> "sqlite3",
														self::CONSTANTS_TIDY_CATEGORY 			=> "tidy",
														self::CONSTANTS_EXIF_CATEGORY 			=> "exif",
														self::CONSTANTS_XHPROF_CATEGORY 		=> "xhprof",
														self::CONSTANTS_XDEBUG_CATEGORY 		=> "xdebug"
																);
	
	
	// exceptions
    const EXCEPTION_MESSAGE_INVALID_KEY             = "The Supplied Key Cannot Be Used To Define A Constant, Use Valid PHP Variable Names";
	const EXCEPTION_MESSAGE_INVALID_VALUE 			= "The Value Supplied Cannot Be Used To Define A Constant, Use (NULL, int, string, bool or float)";
	const EXCEPTION_MESSAGE_CONSTANT_DEFINED		= "A Constant Already Exist With The Supplied Name, Please Choose A Unique Name";

    // regex patterns
    const VALID_VARIABLE_REGEX_PATTERN              = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

    /**
     * This method returns the list of constant categories catered for by the class
     * This should match the number of defined constant categories in PHP
     * @return array
     */
    public function getCategoryList()
	{
		// you can use $this or __CLASS__ (__CLASS__) only works in php 5.3 upwards... because it is wat is called late static binding
		$oReflect = new \ReflectionClass($this);
        $aReturnedConstants = (array) $oReflect->getConstants();
        $aReturnedConstants = array_filter($aReturnedConstants, function($sKey){
           return   (is_string($sKey) && (strpos($sKey,"CONSTANTS") === 0)) ;
        });

        return $aReturnedConstants;
	}

    /**
     * This method returns an array of constant categories that has not been catered defined/added to the array mappings
     * This may defer from system to system
     * @return array
     */
    public function getUndefinedConstantCategories()
    {
        $aMappingsValues = array_values($this->aCategoriesMappings);
        $aDefinedConstants = array_keys(get_defined_constants(true));
        if($aMappingsValues !== $aDefinedConstants)
        {
            return array_diff($aDefinedConstants, $aMappingsValues);
        }
        else
        {
            return array();
        }
    }


    /**
     * This method exposes the array mappings to public classes
     * @return array
     */
    public function getArrayMapping()
    {
        return $this->aCategoriesMappings;
    }
}

