<?php

namespace RefactoringGuru\Composite\Conceptual;

/**
 * The base Component class declares common operations for both simple and
 * complex objects of a composition.
 */
abstract class FileSystemEntity
{
    /**
     * @var FileSystemEntity
     */
    protected $parent;

    /**
     * Optionally, the base Component can declare an interface for setting and
     * accessing a parent of the component in a tree structure. It can also
     * provide some default implementation for these methods.
     */
    public function setParent(FileSystemEntity $parent)
    {
        $this->parent = $parent;
    }

    /**
     * In some cases, it would be beneficial to define the child-management
     * operations right in the base Component class. This way, you won't need to
     * expose any concrete component classes to the client code, even during the
     * object tree assembly. The downside is that these methods will be empty
     * for the leaf-level components.
     */
    public function add(FileSystemEntity $component): void { }

    public function remove(FileSystemEntity $component): void { }

    /**
     * The base Component may implement some default behavior or leave it to
     * concrete classes (by declaring the method containing the behavior as
     * "abstract").
     */
    abstract public function operation(): string;

    abstract public function getName(): string;

    abstract public function getSize(): int;

}

/**
 * The Leaf class represents the end objects of a composition. A leaf can't have
 * any children.
 *
 * Usually, it's the Leaf objects that do the actual work, whereas Composite
 * objects only delegate to their sub-components.
 */
class File extends FileSystemEntity
{
    public function getName(): string
    {
        return self::class;
    }

    public function getSize(): int
    {
        return 1;
    }

    public function operation(): string
    {
        return "Leaf";
    }
}

/**
 * The Composite class represents the complex components that may have children.
 * Usually, the Composite objects delegate the actual work to their children and
 * then "sum-up" the result.
 */
class Directory extends FileSystemEntity
{
    /**
     * @var \SplObjectStorage
     */
    protected $children;

    public function __construct()
    {
        $this->children = new \SplObjectStorage();
    }

    /**
     * A composite object can add or remove other components (both simple or
     * complex) to or from its child list.
     */
    public function add(FileSystemEntity $component): void
    {
        $this->children->attach($component);
        $component->setParent($this);
    }

    public function remove(FileSystemEntity $component): void
    {
        $this->children->detach($component);
        $component->setParent(null);
    }

    public function isComposite(): bool
    {
        return true;
    }

    /**
     * The Composite executes its primary logic in a particular way. It
     * traverses recursively through all its children, collecting and summing
     * their results. Since the composite's children pass these calls to their
     * children and so forth, the whole object tree is traversed as a result.
     */
    public function operation(): string
    {
        $results = [];
        foreach ($this->children as $child) {
            $results[] = $child->operation();
        }

        return "Branch(" . implode("+", $results) . ")";
    }

    public function getName(): string
    {
        return self::class;
    }

    public function getSize(): int
    {
        return count($this->children);
    }

    public function listContent(): \SplObjectStorage
    {
        return $this->children;
    }
}

/**
 * ...as well as the complex composites.
 */
$root = new Directory();

$directory1 = new Directory();
$directory1->add(new File());
$directory1->add(new File());

$directory2 = new Directory();
$directory2->add(new File());

$root->add($directory1);
$root->add($directory2);