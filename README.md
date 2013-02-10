constantaccess
==============

This library makes it possible to create and read (access) constants using an array-like object or a typical class object to make it possible to use constants in strings without the need of concatenation of strings

<br/>

## Example
Create an object of the constant access library and then start creating or reading constants
<pre>
$oConst = new ConstantAccess\ConstantAccess();

or

$oConst = new Constants;
</pre>

<br/>

## Instantiating The Constant Class With An Array
you can supply an array key=>pair values for constants to create, **NOTE: this array should be a 1 dimensional array**

e.g
<pre>
	$aData = array(
					'const1'  => 2,
					'const2'  => 22,
					'_const3' => 'another constant'
				   );

 // then create it now as

 $oConst = new Constants($aData);
</pre>

<br/>

### Creating Constants Using Object Method or Array Access
<pre>
$oConst->CONST1 = 23;               This creates a constant called CONST1
$oConst['CONST2'] = "constant 2";   This creates another constant called CONST2
</pre>

<br/>

### Throwing Exceptions
To create a valid php constant, the following conditions must be met

- A constant key can only be a valid php variable name 
- A Constant value can only be a value of scalar type, 

Before creating a constant, the above tests are conducted, hence there are possibilities of exceptions been thrown if any of the above listed conditions are not adhered to or met

The ConstantAccess **dies** silently i.e it does not throw any exception by default but for good programming practice, you should handle all possibilites of exceptions

<br/>

### Enabling Exceptions
You can enable the exceptions in two(2) ways, 

 - At the creation of the class object
 - By using the **setThrowException** method

 **e.g**
 <pre>
 1 - $oConst = new Constant(array(), true);
 2 - $oConst->setThrowException(false);
 </pre>

<br/>


### Default Return Value
If a constant is not defined, you can configure a default return value that is returned in that case instead of breaking ur application

<pre>
 e.g To set the default return value to null, you do the following

 $oConst->setValueReturnIfNotDefined(null);

 hence, $oConst->UNDEFINED; would return null
</pre>


<br/>

### Reading / Accessing Constants

<pre>
print "this is a trial message with {$oConst->CONST1} or another {$oConst->CONST2}";
</pre>

<br/>

### Tests
 just run Phpunit in the folder where you have placed the library


<br/>
### Examples

examples are located in the **/examples** folder

