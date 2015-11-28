<?php
namespace Samcrosoft\ConstantAccess;
//
///**
// * Use the current working directory as base for autoloading the required classes
// */
//spl_autoload_register (function ($class) {
//    $sVendorDir = dirname(__DIR__);
//    $file = str_replace ('\\', DIRECTORY_SEPARATOR, ltrim ($class, '\\')) . '.php';
//    if (file_exists($sVendorDir . DIRECTORY_SEPARATOR . $file))
//    {
//        require_once($sVendorDir .DIRECTORY_SEPARATOR .$file);
//        return true;
//    }
//    return false;
//});

/**
 * @todo - remove this
 * Create a class alias here so that \ConstantAccess\ConstantAccess is just called as ConstantAccess
 * This would save the developers time
 */
class_alias('Samcrosoft\ConstantAccess\ConstantAccess', 'Constants');