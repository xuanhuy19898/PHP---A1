<?php
//I, Xuan Huy Pham, 000899551, certify that this material is my original work. No other person's work has been used without suitable acknowledgment and I have not made my work available to anyone else.

/**
 * PHPDOC 
 * @author Xuan Huy Pham / 000899551
 * @version 2023309.00
 * @package COMP 10260 Assignment 1
 */


//to GET the serial number from the GET parameter
//references: https://www.w3schools.com/php/func_string_substr.asp
$serial_number = $_GET['serial_number'];

//check if the serial number has exactly 10 characters, including exactly 7 digits
//exit the script if input is invalid
if (strlen($serial_number) != 10) {
    echo "Invalid input: Numeric portion must have exactly 7 digits! Try again..";
    exit; 
} 
//using substr function to extract a part of the whole string
$numeric_portion = substr($serial_number, 3);


/**
 * check if a number is a palindrome
 * @param  string $number the numeric portion of the serial number
 * @return bool whether the number is palindrome
 */
function palindrome($number) {
    return $number == strrev($number);
}


/**
 * check if that number is ladder up
 * @param string $number the numberic part
 * @return bool whether it's ladder up
 * ref: https://www.w3schools.com/php/func_string_strlen.asp
 */
function ladderUp($number) {
    $length = strlen($number);//calculate the length of the string
    for ($i = 1; $i < $length; $i++) {
        if ($number[$i] != $number[$i - 1] + 1) {
            //check if current digit is not equal to the previous one
            return false; //then return false
        }
    }
    return true; //return true if the loop completes without encountering the digits are not increasing consecutively 
}



/**
 * check if the number is ladder down
 * @param string $number
 * @return bool whether it's ladder down
 * using the same function for ladderUp
 */
function ladderDown($number) {
    $length = strlen($number);
    for ($i = 1; $i < $length; $i++) {
        if ($number[$i] != $number[$i - 1] - 1) {
            return false;
        }
    }
    return true; 
}

/**
 * check if the number is ladder up-down
 * 
 * seperate the length into 2 parts
 * if the first half follows the ladder up pattern and the second half follows the ladder down pattern, then return TRUE because it follows "ladder up-down" pattern
 * @param string $number 
 * @return bool whether it's ladder up-down
 */
function ladderUpDown($number) {
    $length = strlen($number);
    if ($length != 7) { //make sure the length of the numeric portion is 7
        return false;
    }
    $middle = $length / 2;
    $first_half = substr($number, 0, $middle);
    $second_half = substr($number, $middle);
    if (ladderUp($first_half) && ladderDown($second_half)) {
        return true;
    }
    return false;
}


/**
 * check if the number is ladder down-up
 * 
 * if the first half follows the ladder down, the second half follows the ladder up pattern, return TRUE, otherwise return FALSE
 * @param string $number
 * @return bool whether the number is ladder down-up
 * using the same method as ladderUpDown but reverse
 */
function ladderDownUp($number) {
    $length = strlen($number);
    if ($length != 7) {
        return false;
    }
    $middle = $length / 2;
    $first_half = substr($number, 0, $middle);
    $second_half = substr($number, $middle);
    if (ladderDown($first_half) && ladderUp($second_half)) {
        return true;
    }
    return false;
}

/**
 * check if the number is a rotator note
 * 
 * initialize an array named $rotatable and put all the valid digits in that array
 * check if the current digit at index %i in the input is in the array, if it can't find that digit in the array, return FALSE
 * @param string $number
 * @return bool whether it's a rotator note
 */
function rotator($number) {
    $rotatable = ['0', '1', '6', '8', '9'];

    for ($i = 0; $i < strlen($number); $i++) {
        if (!in_array($number[$i], $rotatable)) {
            return false;
        }
    }
    return true;
}


/**
 * check if the number is a binary note
 * 
 * check if all digits are either 0 or 1
 * @param $number
 * @return bool whether it's a binary note
 */
function binary($number) {
    for ($i = 0; $i < strlen($number); $i++) {
        if ($number[$i] !== '0' && $number[$i] !== '1') {
            return false;
        }
    }
    return true;
}


//initialize this array to store results
$results = [];

//call the function to check if the the numeric portion matches different patterns or just one
//call palindrome function to check if the numeric portion is a palindrome, then store in $radar
//call all the other functions to check if the numeric portion follows any pattern and then store the result in the corresponding variable
$radar = palindrome($numeric_portion);
$ladderUp = ladderUp($numeric_portion);
$ladderDown = ladderDown($numeric_portion);
$ladderUpDown = ladderUpDown($numeric_portion);
$ladderDownUp = ladderDownUp($numeric_portion);
$rotator = rotator($numeric_portion);
$binary = binary($numeric_portion); 

//if statement to check if the numeric portion is a radar note, which means it's a palindrome. if it is, keep going with the next stage
if ($radar) {
    //check if all the digits in the portion are the same by converting the portion into an array of individual digits using 'str_split'
    //then use 'array_unique' to remove duplicates and then counting the remaining unique ones, if there's only one unique digit, it means they are all the same
    //ref: https://www.php.net/manual/en/function.array-unique.php
    if (strlen($numeric_portion) == 7 && count(array_unique(str_split($numeric_portion))) == 1) {
        $results[] = 'solid serial number'; //it's solid serial number if it satisties all the above conditions
    } else {
        $results[] = 'radar note'; //otherwise it's just "radar note"
    }
}

if ($rotator) {$results[] = 'rotator note';}

if ($binary) {$results[] = 'binary note';}

if ($ladderUp) {$results[] = 'ladder up';}

if ($ladderDown) {$results[] = 'ladder down';}

if ($ladderUpDown) {$results[] = 'ladder up-down';}

if ($ladderDownUp) {$results[] = 'ladder down-up';}

//if none of the categories are matched, the note is classified as "uninteresting"
if (empty($results)) {
    $results[] = 'uninteresting serial number';
}

//output the list of all matching serial number group as list items
//this foreach loop helps create an HTML list of classification results based on the contents of array $results
foreach ($results as $results) {
    echo "<li>$results</li>";
}
?>
