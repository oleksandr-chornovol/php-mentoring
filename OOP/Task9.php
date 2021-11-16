<?php

abstract class Person
{
  public string $name;
    
  public int $age;
    
  public string $gender;

  public function __construct(string $name, int $age, string $gender)
  {
    $this->name = $name;
    
    $this->age = $age;
    
    $this->gender = $gender;
  }
  
  abstract public function introduce(): string;
  
  public function greet($name): string
  {
    return "Hello $name";
  }
}

final class Child extends Person
{
  public array $aspirations;

  public function __construct(string $name, int $age, string $gender, array $aspirations)
  {
    parent::__construct($name, $age, $gender);
    
    $this->aspirations = $aspirations;
  }
  
  public function introduce(): string
  {
    return "Hi, I'm $this->name and I am $this->age years old";
  }
  
  public function greet($name): string
  {
    return "Hi $name, let's play!";
  }
  
  public function say_dreams(): string
  {
    return 'I would like to be a(n) ' . say_list($this->aspirations) . ' when I grow up.';
  }
}

class ComputerProgrammer extends Person
{
  public $occupation = 'Computer Programmer';

  public function introduce(): string
  {
    return "Hello, my name is $this->name, I am $this->age years old and I am a(n) $this->occupation";
  }
  
  public function greet($name): string
  {
    return "Hello $name, I'm $this->name, nice to meet you";
  }
  
  public function advertise(): string
  {
    return 'Don\'t forget to check out my coding projects';
  }
}
