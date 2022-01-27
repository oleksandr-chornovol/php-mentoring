<?php

namespace RefactoringGuru\Adapter\Conceptual;

/**
 * The Adaptee contains some useful behavior, but its interface is incompatible
 * with the existing client code. The Adaptee needs some adaptation before the
 * client code can use it.
 */

interface ASCIIStackInterface {
    public function push(string $value): void;

    public function pop(): string;
}

interface IntegerStackInterface {
    public function push(int $value): void;

    public function pop(): int;
}

class Adaptee implements IntegerStackInterface
{
    private array $stack;

    public function push(int $value): void
    {
        $this->stack[] = $value;
    }

    public function pop(): int
    {
        return array_pop($this->stack);
    }
}

/**
 * The Adapter makes the Adaptee's interface compatible with the Target's
 * interface.
 */
class Adapter implements ASCIIStackInterface
{
    public function __construct(private Adaptee $adaptee)
    {
    }

    public function push(string $value): void
    {
        $this->adaptee->push(ord($value));
    }

    public function pop(): string
    {
        return chr($this->adaptee->pop());
    }
}

/**
 * The client code supports all classes that follow the Target interface.
 */
function clientCode(ASCIIStackInterface $target, string $value)
{
    $target->push($value);

    $result = $target->pop();
}

$adaptee = new Adaptee();
$adapter = new Adapter($adaptee);

clientCode($adapter, 'q');