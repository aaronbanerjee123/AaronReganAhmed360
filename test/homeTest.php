<?php
//vendor/bin/phpunit test/homeTest.php
class homeTest extends \PHPUnit\Framework\TestCase
{

    public function testThatStringsAreTheSame(){

        $string1 = "regan";
        $string2 = "regan";

        $this-> assertSame($string1, $string2);
        $this -> assertTrue($string1 == $string2); 

    }


}