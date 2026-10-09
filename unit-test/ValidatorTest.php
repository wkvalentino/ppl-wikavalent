<?php
//file: ValidatorTest.php
use PHPUnit\Framework\TestCase;

require_once 'Validator.php';

class ValidatorTest extends TestCase
{
    // == Test Age Validation ==
    public function testValidAge()
    {
        $this->assertTrue(validateAge(25));
        $this->assertTrue(validateAge(-25));
    }
    public function testEmptyAgeThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        validateAge('');
    }
}