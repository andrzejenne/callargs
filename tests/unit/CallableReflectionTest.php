<?php

namespace BigBIT\CallArgs\Tests\unit;

// @todo - bootstrap
use BigBIT\CallArgs\CallableReflection;
use BigBIT\CallArgs\Tests\ExampleClass;

require_once __DIR__ . "/../examples.php";

class CallableReflectionTest extends \PHPUnit\Framework\TestCase
{
    public function testGetParameters()
    {
        $ref = new CallableReflection('\BigBIT\CallArgs\Tests\exampleFunction');
        $this->assertInstanceOf(\ReflectionFunctionAbstract::class, $ref->getReflection());
        $params = $ref->getParameters();
        $this->assertCount(4, $params);

        $ref = new CallableReflection(ExampleClass::class . '::exampleStaticMethod');
        $this->assertInstanceOf(\ReflectionFunctionAbstract::class, $ref->getReflection());
        $params = $ref->getParameters();
        $this->assertCount(4, $params);

        $ref = new CallableReflection([ExampleClass::class, 'exampleStaticMethod']);
        $this->assertInstanceOf(\ReflectionFunctionAbstract::class, $ref->getReflection());
        $params = $ref->getParameters();
        $this->assertCount(4, $params);

        $ref = new CallableReflection([new ExampleClass(), 'exampleMethod']);
        $this->assertInstanceOf(\ReflectionFunctionAbstract::class, $ref->getReflection());
        $params = $ref->getParameters();
        $this->assertCount(4, $params);

        $this->assertEquals(ExampleClass::class, $params[0]->getClass()->getName());
        // @todo - add more assertions
        $this->assertTrue($params[1]->getType()->isBuiltin());
        $this->assertTrue($params[2]->getType()->allowsNull());
        $this->assertEquals("", $params[3]->getDefaultValue());
    }
}
