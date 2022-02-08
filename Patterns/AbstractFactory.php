<?php

namespace RefactoringGuru\AbstractFactory\Conceptual;

use http\Exception\InvalidArgumentException;

/**
 * The Abstract Factory interface declares a set of methods that return
 * different abstract products. These products are called a family and are
 * related by a high-level theme or concept. Products of one family are usually
 * able to collaborate among themselves. A family of products may have several
 * variants, but the products of one variant are incompatible with products of
 * another.
 */
interface PersonRepository
{
    public function savePHPDeveloper(array $data): void;
    public function saveGODeveloper(array $data): void;

    public function readPHPDevelopers(): array;
    public function readGODevelopers(): array;

    public function readPHPDeveloper(string $name): AbstractPHPDeveloper;
    public function readGODeveloper(string $name): AbstractGODeveloper;
}

/**
 * Concrete Factories produce a family of products that belong to a single
 * variant. The factory guarantees that resulting products are compatible. Note
 * that signatures of the Concrete Factory's methods return an abstract product,
 * while inside the method a concrete product is instantiated.
 */
class FSPersonRepository implements PersonRepository
{
    private array $PHPDevelopers;

    private array $GODevelopers;

    public function savePHPDeveloper(array $data): void
    {
        $this->PHPDevelopers[$data['name']] = new PHPFSDeveloper($data);
    }

    public function saveGODeveloper(array $data): void
    {
        $this->GODevelopers[$data['name']] = new GOFSDeveloper($data);
    }

    public function readPHPDevelopers(): array
    {
        return $this->PHPDevelopers;
    }

    public function readGODevelopers(): array
    {
        return $this->GODevelopers;
    }

    public function readPHPDeveloper(string $name): AbstractPHPDeveloper
    {
        if (! isset($this->PHPDevelopers[$name])) {
            throw new InvalidArgumentException('user does not exist');
        }

        return $this->PHPDevelopers[$name];
    }

    public function readGODeveloper(string $name): AbstractGODeveloper
    {
        if (! isset($this->GODevelopers[$name])) {
            throw new InvalidArgumentException('user does not exist');
        }

        return $this->GODevelopers[$name];
    }
}

/**
 * Each Concrete Factory has a corresponding product variant.
 */
class DBPersonRepository implements PersonRepository
{
    private array $PHPDevelopers;

    private array $GODevelopers;


    public function savePHPDeveloper(array $data): void
    {
        $this->PHPDevelopers[$data['name']] = new PHPDBDeveloper($data);
    }

    public function saveGODeveloper(array $data): void
    {
        $this->GODevelopers[$data['name']] = new GODBDeveloper($data);
    }

    public function readPHPDevelopers(): array
    {
        return $this->PHPDevelopers;
    }

    public function readGODevelopers(): array
    {
        return $this->GODevelopers;
    }

    public function readPHPDeveloper(string $name): AbstractPHPDeveloper
    {
        if (! isset($this->PHPDevelopers[$name])) {
            throw new InvalidArgumentException('user does not exist');
        }

        return $this->PHPDevelopers[$name];
    }

    public function readGODeveloper(string $name): AbstractGODeveloper
    {
        if (! isset($this->GODevelopers[$name])) {
            throw new InvalidArgumentException('user does not exist');
        }

        return $this->GODevelopers[$name];
    }
}

/**
 * Each distinct product of a product family should have a base interface. All
 * variants of the product must implement this interface.
 */
interface AbstractPHPDeveloper
{
}

/**
 * Concrete Products are created by corresponding Concrete Factories.
 */
class PHPFSDeveloper implements AbstractPHPDeveloper
{
    public function __construct(public array $data)
    {
    }
}

class PHPDBDeveloper implements AbstractPHPDeveloper
{
    public function __construct(public array $data)
    {
    }
}

/**
 * Here's the the base interface of another product. All products can interact
 * with each other, but proper interaction is possible only between products of
 * the same concrete variant.
 */
interface AbstractGODeveloper
{
}

/**
 * Concrete Products are created by corresponding Concrete Factories.
 */
class GODBDeveloper implements AbstractGODeveloper
{
    public function __construct(public array $data)
    {
    }
}

class GOFSDeveloper implements AbstractGODeveloper
{
    public function __construct(public array $data)
    {
    }
}

/**
 * The client code works with factories and products only through abstract
 * types: AbstractFactory and AbstractProduct. This lets you pass any factory or
 * product subclass to the client code without breaking it.
 */
function clientCode(PersonRepository $factory, array $PHPData, array $GOdata)
{
    if (! isset($PHPData['name']) || ! isset($GOdata['name'])) {
        throw new InvalidArgumentException('name does not exist');
    }

    $factory->savePHPDeveloper($PHPData);
    $factory->saveGODeveloper($GOdata);

    $PHPDevelopers = $factory->readPHPDevelopers();
    $GODevelopers = $factory->readGODevelopers();

    $PHPDeveloper = $factory->readPHPDeveloper($PHPData['name']);
    $GODeveloper = $factory->readGODeveloper($GOdata['name']);
}

/**
 * The client code can work with any concrete factory class.
 */
echo "Client: Testing client code with the first factory type:\n";
clientCode(new FSPersonRepository(), ['name' => 'qwe'], ['name' => 'rty']);

echo "\n";

echo "Client: Testing the same client code with the second factory type:\n";
clientCode(new DBPersonRepository(), ['name' => 'uio'], ['name' => 'pas']);