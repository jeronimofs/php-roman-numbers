# php-roman-numbers
Support for roman numbers in PHP

# Architecture
It was implemented a simple helper class, 
namespaced "\Jeronimofagundes\Numbers\Roman\Helper", 
which have two methods to convert to and from arabic numbers.

The autoloading was used following PHP FIG's PSR-4 autoloading 
standards.

The source code is inside the "src" directory. 
Dependencies are inside "vendor" directory. 
Tests are inside "tests" folder.

# Testing

To perform unitary tests I used PHPUnit framework. There is
one class contaning the tests for the Helper class.

# Problem-solving
## Conversion Arabic to Roman
The first thing I checked is if the arabic number fits the 
range [1-3999]. This range was defined by [Wikipedia's 
Roman numerals article](https://en.wikipedia.org/wiki/Roman_numerals).

After that, I fill the input number with zeros to the left so it reaches 
4 digits long. Example: 14 turns into 0014.

The next step is convert each character into its corresponding roman. 
These correspondences are mapped in a constant TO_ROMAN inside the
Helper class. There is mappings for "ones", "tens", "hundreds" and 
"thousands". This way, the first 0 is ignored, the second one
ignored as well, 1 turns into X and 4 turns into IV. That means
the returned string is XIV.

## Conversion Roman to Arabic
This conversion starts checking of the given roman number is valid. 
I did this using a regular expression.

I mapped some correspondences in a constant FROM_ROMAN in the Helper class. 
Using this, I read the roman number in the following way:
1. I start from the most left character.
2. I read two characters. If this correspondence is mapped in the 
FROM_ROMAN array, it means it is a subtractive correspondence (like
IV, XC or CM), and it gets converted. We move the pointer two 
characters right and go to step 2 again.
3. If there is no correspondence in the FROM_ROMAN array, it means
it is not a subtractive correspondence. So, we just read one character. 
That character will have a correspondence in the array, and that value
is added to the final result. We move one character to the right and
go back to the step two.
4. The processing ends when the roman number is finished. 

# How to use this library
In order to one use this library, he/she can require it with composer, 
the standard PHP library package manager.

```
composer require "jeronimofagundes/php-roman-numbers:1.0.0"
```  

and use the following class in his/her code:
```
...
use \Jeronimofagundes\Numbers\Roman\Helper;
...
echo Helper::fromArabic(2019); // prints MMXIX
echo Helper::toArabic('MMXIX'); // prints 2019
... 
```

I included a file named example.php showing how to use the library. 
To run it, follow this steps:
1. Clone this repository and cd into it
    ```shell script
    git clone https://github.com/jeronimofagundes/php-roman-numbers.git
    cd php-roman-numbers
    ```
2. . Pull the docker image
    ```shell script
    docker pull jeronimofagundes/php-composer:latest
    ```
3. Install the dependencies with composer
    ```shell script
    docker run -it -u="$UID" -v $PWD:/app -w="/app" jeronimofagundes/php-composer:latest composer install 
    ```
4. Run the file example.php:
    ```shell script
    docker run -it -u="$UID" -v $pwd:/app -w="/app" jeronimofagundes/php-composer:latest php example.php 
    ```

# How to test it
We need to use PHPUnit to execute the tests, 
and we will do it using docker.
Follow this steps:
1. Clone this repository and cd into it
    ```shell script
    git clone https://github.com/jeronimofagundes/php-roman-numbers.git
    cd php-roman-numbers
    ```
2. Pull the docker image
    ```shell script
    docker pull jeronimofagundes/php-composer:latest
    ```
4. Run PHPUnit
    ```shell script
    docker run -it -u="$UID" -v $PWD:/app -w="/app" jeronimofagundes/php-composer:latest /app/phpunit --bootstrap /app/vendor/autoload.php /app/tests
    ```
      