<?php
//I, Xuan Huy Pham, 000899551, certify that this material is my original work. No other person's work has been used without suitable acknowledgment and I have not made my work available to anyone else.

/**
 * PHPDOC 
 * @author Xuan Huy Pham / 000899551
 * @version 2023309.00
 * @package COMP 10260 Assignment 1
 */


//to GET the number of rows from the GET para
$rows = $_GET['rows'];

/**
 * create a table row based on the given number
 * @param int $rowNumber the row nummber
 * @return string the output for the table row
 */
function createRow($rowNumber) {
    //create the first table row. functionstr_repeat is to repeat the $rowNumber a number of times specified by $rowNumber
    $column1 = str_repeat($rowNumber, $rowNumber);
    //calculate the sum for the second column of the table row. it splits the string $column1 into an array of individual digits using str_split then use array_sum to calculate the sum of those
    $column2 = array_sum(str_split($column1)); 
    //create the output row
    $outputRow = "<tr><td>$column1</td><td>$column2</td></tr>";
    return $outputRow;
}

//create the result table
$results = '<table>';//using the opening <table> tag
for ($i=1;$i<=$rows;$i++) {//this loop will create a new row each iteration from 1 to the value of $rows
    $results .= createRow($i);//add a new row to the table for each value of i
}
$results .= '</table>';//using the closing tag signifies the end of the tablle
//print the result table
echo $results;
?>
