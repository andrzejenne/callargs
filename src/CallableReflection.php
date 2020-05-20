<?php declare(strict_types=1);

namespace BigBIT\CallArgs;

use ReflectionException;
use ReflectionFunctionAbstract;

/**
 * Class CallableReflectionFactory
 * @package BigBIT\CallArgs
 */
class CallableReflection
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var ReflectionFunctionAbstract
     */
    private $reflection;

    /**
     * CallableReflection constructor.
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @return ReflectionFunctionAbstract
     * @throws ReflectionException
     * @throws \Exception
     */
    public function getReflection() {
        if ($this->reflection === null) {
            // static or functions
            if (\is_string($this->callable)) {
                $this->reflection = \strpos($this->callable, '::') ?
                    new \ReflectionMethod('\\' . \ltrim($this->callable, '\\')) :
                    new \ReflectionFunction($this->callable);
            } else {
                // methods
                if (\is_array($this->callable)) {
                    $this->reflection = new \ReflectionMethod(
                        \is_object($this->callable[0]) ? \get_class($this->callable[0]) : $this->callable[0],
                        $this->callable[1]
                    );
                } else {
                    // invokable
                    if ((\is_object($this->callable) || \is_string($this->callable))
                        && \method_exists($this->callable, '__invoke')
                    ) {
                        $this->reflection = new \ReflectionMethod($this->callable, '__invoke');
                    }
                }
            }

            if ($this->reflection === null) {
                throw new \ReflectionException("Cannot get callable reflection.");
            }
        }

        return $this->reflection;
    }

    /**
     * @return \ReflectionParameter[]
     * @throws ReflectionException
     */
    public function getParameters()
    {
        return $this->getReflection()
            ->getParameters();
    }

}
