<?php

namespace BigBIT\CallArgs\Tests;

class ExampleClass {
    public function exampleMethod(ExampleClass $inst, float $flt, ?int $num = null, $some = "") { }

    public static function exampleStaticMethod(ExampleClass $inst, float $flt, ?int $num = null, $some = "") { }
}

function exampleFunction(ExampleClass $inst, float $flt, ?int $num = null, $some = "") { }
