
# CSSLoL - CSS optimizer in PHP
An standalone CSS optimizer in PHP.

<img src='https://igorfaria.github.io/CSSLoL/assets/img/logo.png' />

This is a *CSS optimizer* that parse CSS code into an set of associatives arrays, allowing to manipulate the CSS with PHP and execute the magic, outputing as a text or into a file.

### Optimize
-  [x] Remove zeros when it is not needed (0.3s -> .3s)
-  [x] Colors rgb to hex (*rgb(255,255,255)* -> *#fff*)
-  [x] Abbreviation for hex (*#ffcc00* -> *#fc0*)
-  [x] Add prefixes (*-webkit-*, *-moz-*, *-ms-* and *-o-*)
- [ ] Replace multiples related properties with the shorthanded version
- [ ] Remove duplicated properties with the same selector
-  [x] Support to media queries
-  [x] Support to animations (*-webkit-*)

### Minify

-  [x] Yeah it does, by nature. Removing whitespaces, tabs, comments and those things.

<br>

## Installing
##### Prerequisites: PHP 5.4+
Just download the file **CSSLoL.class.php** and use it, there is no others external dependencies to the CSSLoL class.
Of course you can download the folder /tests/ if you want some examples to how use and to test the funcionalities.


## Usage
-  [x]  **append(*$array* or *$string*)** - To add some css rules to the end

```php
<?php
$CSSLoL = new CSSLoL();
// Set initial CSS 
$CSSLoL->set('body{color:#333333;}');
// Add rule to the end of the CSS
$CSSLoL->append(array(
    'p' => array('color'=>'#222222'),
));
echo $CSS->get('string');
```

Will output: 
```css
body{color:#333}p{color:#222}
```
<br><br>
-  [x]  **prepend(*$array* or *$string*)** - To add some css rules to the beginning

```php
<?php
$CSSLoL = new CSSLoL();
// Set initial CSS 
$CSSLoL->set('body{color:#333333;}');
// Add rule to the beginning of the CSS
$CSSLoL->prepend(array(
    'p' => array('color'=>'#222222'),
));
echo $CSS->get('string');
```

Will output: 
```css
p{color:#222}body{color:#333}
```
<br><br>
-  [x]  **load('*string with local path or remote url*')** - To load some css file local or remote

Loading a CSS file from a local path
```php
<?php
$CSSLoL = new CSSLoL();
// Load CSS from a file
$CSSLoL->load('tests/example.css');
echo $CSS->get('string');
```

Will output: 
```css
body{color:#333}
```

Loading a CSS file from an URL
```php
<?php
$CSSLoL = new CSSLoL();
// Load CSS from a file
$CSSLoL->load('https://localhost/tests/example.css');
echo $CSS->get('string');
```

Will output: 
```css
body{color:#333}
```
<br><br>
-  [x]  **get(*'array'* or *'string'*)** - to get the array of parsed css to change the data structury


The default value of the get() parameter is 'array', so the return will be an set of associatives arrays
```php
<?php
$CSSLoL = new CSSLoL();
$CSSLoL->load('tests/example.css');
// Output as an array
echo $CSS->get();
```

Will output: 
```
array(4) {
  [0]=>
  array(1) {
    ["body"]=>
    array(1) {
      ["color"]=>
      string(4) "#333"
    }
  }
```
<br><br>
If you need the CSS in a string you have to indicate that with the string value 'string' 
```php
<?php
$CSSLoL = new CSSLoL();
$CSSLoL->load('tests/example.css');
// Output as a string
echo $CSS->get('string');
```

Will output: 
```css
body{color:#333}
```
<br><br>

-  [x]  **save(*'name.css','path/css',true*)** - Save the final css to some final file (minified or not)

```php
<?php
$CSSLoL = new CSSLoL();
$CSSLoL->set('body{color:#333}');
// Create a minified file
if($CSS->save('tests/css/example-min.css')){
  echo 'File created with success';
} else {
  echo 'Something wrong...';
}
```

Will output an file minified in the indicated path.
For more complexes paths, you could indicate the final name of the file and the destination using the second parameter.

```php
<?php
$CSSLoL = new CSSLoL();
$CSSLoL->set('body{color:#333}');
// Create a minified file
if($CSS->save('example.css','tests/css')){
  echo 'File created with success';
} else {
  echo 'Something wrong...';
}
```

The third parameter indicate if the final CSS will be minified or idented. The default value is true;
```php
<?php
$CSSLoL = new CSSLoL();
$CSSLoL->set('body{color:#333}');
// Create an idented file
if($CSS->save('example.css','tests/css',false)){
  echo 'File with CSS idented created with success';
} else {
  echo 'Something went wrong with idented version...';
}
// Create a minified file
if($CSS->save('example.min.css','tests/css',true)){
  echo 'File with CSS minified created with success';
} else {
  echo 'Something went wrong with minified version...';
}
```

<br><br>
-  [x]  **set(*$array* or *$string*)** - to set the array of parsed css or in text, it will not append, it will replace the actual data

You can use the set() method with an string, this string could came from a webform or from loaded from a file for example 
```php
<?php
$CSSLoL = new CSSLoL();
// Set an initial CSS from string
$CSSLoL->set('body{color:#333}');
echo $CSS->get('string');
```

Will output: 
```css
body{color:#333}
```

Or if you have an set of rules structured in an associative array, you can use that too:
```php
<?php
$CSSLoL = new CSSLoL();
// Set an initial CSS from array
$rule = array( 
    'body' => array('color' => '#333')
);
$CSSLoL->set($rule);
echo $CSS->get('string');
```

Will output: 
```css
body{color:#333}
```


<br><br>


#### Configurations

-  [x]  **autoprefixer**  *(default: true)*: add prefixes automatically if not yet defined to specified properties that you define

```php
<?php
// An array with configs
$configs = array(
  // The default value is already true :D
  'autoprefixer' => true,
); 
// Pass it through constructor
$CSSLoL = new CSSLoL($configs);
$CSSLoL->set('.example{transform: rotate(30deg);}');
echo $CSSLoL->get('string',false);
```
Will output
```css
.example {
    -webkit-transform: rotate(30deg);
    -ms-transform: rotate(30deg);
    transform: rotate(30deg);
}
```

- [ ] **duplicated**  *(default: false)*: Remove duplicated properties with the same selector in different parts of your css code.

- [ ] **shorthand**  *(default: false)*: Replace multiples related properties with the shorthanded version.

<br><br>


## Running the tests
The tests are in the **/tests/** folder, just run them into your browser to see the results. They are not that good as a test but I think they do their job. 
Basically the tests *test* the methods in the class, to see if they output what is desired. 
  

## Built With
Google Search, Visual Code Editor, PHP 7, Apache (on Windows),  Git and Github.
 

## Versioning
I use my imagination for versioning. For the versions available, see the [releases on this repository](https://github.com/igorfaria/CSSLoL/releases).

  

## Author
*  **Igor Faria**, myself.
  

There is no other contributors until now, but if someone show up will be in the list of [contributors](https://github.com/igorfaria/CSSLoL/contributors) who participated in this project.

 
## License

  

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details