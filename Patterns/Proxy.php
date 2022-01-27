<?php


namespace RefactoringGuru\Proxy\Conceptual;

use RefactoringGuru\AbstractFactory\Conceptual\AbstractPHPDeveloper;
use RefactoringGuru\AbstractFactory\Conceptual\DBPersonRepository;
use RefactoringGuru\AbstractFactory\Conceptual\PersonRepository;
use RefactoringGuru\AbstractFactory\Conceptual\PHPFSDeveloper;

class Proxy implements PersonRepository
{
    private array $PHPDevelopers;

    /**
     * The Proxy maintains a reference to an object of the RealSubject class. It
     * can be either lazy-loaded or passed to the Proxy by the client.
     */
    public function __construct(private DBPersonRepository $realSubject)
    {
    }

    public function savePHPDeveloper(array $data): void
    {
        $this->PHPDevelopers[$data['name']] = new PHPFSDeveloper($data);
    }

    public function readPHPDeveloper(string $name): AbstractPHPDeveloper
    {
        return $this->PHPDevelopers[$name] ?? $this->realSubject->readPHPDeveloper($name);
    }
}

$realSubject = new DBPersonRepository();
$proxy = new Proxy($realSubject);

$proxy->readPHPDeveloper('qwe');