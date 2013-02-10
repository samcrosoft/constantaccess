<?php
include(__DIR__ . "/../src/ConstantAccess/Constants.php");

// create a new constant access object using the namespace
$oConst = new ConstantAccess\ConstantAccess();

$oConst['CONST1'] = "Example 1";
$oConst['CONST2'] = "Example 2";

print "this is example of {$oConst['CONST1']} - {$oConst['CONST2']} \n";
print "another example using object access {$oConst->CONST1} and access two is {$oConst->CONST2} \n";


print "-------------------------------\n";
print "      EXAMPLE TWO              \n";
print "-------------------------------\n";

unset($oConst);

// create a new constant access object using the Constants class alias
$oConst = new Constants;
$oConst['CONST3'] = "Example 3";

print "the example of another string {$oConst['CONST3']}";