<?php

namespace RefactoringGuru\Decorator\Conceptual;

use http\Exception\InvalidArgumentException;
use RefactoringGuru\AbstractFactory\Conceptual\AbstractGODeveloper;
use RefactoringGuru\AbstractFactory\Conceptual\FSPersonRepository;
use RefactoringGuru\AbstractFactory\Conceptual\PersonRepository;

class PersonRepositoryDecorator implements PersonRepository
{
    protected PersonRepository $component;

    public function __construct(PersonRepository $component)
    {
        $this->component = $component;
    }

    /**
     * The Decorator delegates all work to the wrapped component.
     */
    public function readGODevelopers(): array
    {
        return $this->component->readGODevelopers();
    }

    public function readGODeveloper(string $name): AbstractGODeveloper
    {
        return $this->component->readGODeveloper($name);
    }

    public function saveGODeveloper(array $data): void
    {
        $this->component->saveGODeveloper($data);
    }
}

/**
 * Concrete Decorators call the wrapped object and alter its result in some way.
 */
class LowerCaseReadPersonDecorator extends PersonRepositoryDecorator
{
    public function readGODevelopers(): array
    {
        $developers = parent::readGODevelopers();

        foreach ($developers as $developer) {
            $developer['name'] = strtolower($developer['name']);
        }

        return $developers;
    }

    public function readGODeveloper(string $name): AbstractGODeveloper
    {
        $developer = parent::readGODeveloper($name);

        $developer['name'] = strtolower($developer['name']);

        return $developer;
    }
}

/**
 * Decorators can execute their behavior either before or after the call to a
 * wrapped object.
 */
class UppercaseWritePersonDecorator extends PersonRepositoryDecorator
{
    public function saveGODeveloper(array $data): void
    {
        $data['name'] = strtoupper($data['name']);
        parent::saveGODeveloper($data);
    }
}

/**
 * The client code works with all objects using the Component interface. This
 * way it can stay independent of the concrete classes of components it works
 * with.
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

$simple = new FSPersonRepository();

$decorator1 = new LowerCaseReadPersonDecorator($simple);
$decorator2 = new UppercaseWritePersonDecorator($decorator1);

clientCode($decorator2);