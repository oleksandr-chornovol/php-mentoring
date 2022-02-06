<?php

namespace RefactoringGuru\Strategy\Conceptual;

/**
 * The Context defines the interface of interest to clients.
 */
class EmployeeCollection
{
    private array $employees;

    /**
     * Usually, the Context accepts a strategy through the constructor, but also
     * provides a setter to change it at runtime.
     */
    public function __construct(private Strategy $strategy)
    {
    }

    /**
     * Usually, the Context allows replacing a Strategy object at runtime.
     */
    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * The Context delegates some work to the Strategy object instead of
     * implementing multiple versions of the algorithm on its own.
     */
    public function sort(): array
    {
        return $this->strategy->sort($this->employees);
    }
}

/**
 * The Strategy interface declares operations common to all supported versions
 * of some algorithm.
 *
 * The Context uses this interface to call the algorithm defined by Concrete
 * Strategies.
 */
interface Strategy
{
    public function sort(array $data): array;
}

/**
 * Concrete Strategies implement the algorithm while following the base Strategy
 * interface. The interface makes them interchangeable in the Context.
 */
class SortByDepartmentStrategy implements Strategy
{
    public function sort(array $data): array
    {
        usort($data, function($a, $b) {
            return $a['department'] <=> $b['department'];
        });

        return $data;
    }
}

class SortByNameStrategy implements Strategy
{
    public function sort(array $data): array
    {
        usort($data, function($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        return $data;
    }
}

class SortBySalaryStrategy implements Strategy
{
    public function sort(array $data): array
    {
        usort($data, function($a, $b) {
            return $a['salary'] <=> $b['salary'];
        });

        return $data;
    }
}

/**
 * The client code picks a concrete strategy and passes it to the context. The
 * client should be aware of the differences between strategies in order to make
 * the right choice.
 */
$context = new EmployeeCollection(new SortByDepartmentStrategy());
$context->sort();

$context->setStrategy(new SortByNameStrategy());
$context->sort();

$context->setStrategy(new SortBySalaryStrategy());
$context->sort();