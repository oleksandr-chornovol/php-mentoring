<?php

class Person
{
  const species = 'Homo Sapiens';
  
  public function __construct(public string $name, public int $age, public string $occupation) {}
  
  public function introduce(): string
  {
    return "Hello, my name is $this->name";
  }
  
  public function describe_job(): string
  {
    return "I am currently working as a(n) $this->occupation";
  }
  
  public static function greet_extraterrestrials(string $species): string
  {
    return "Welcome to Planet Earth $species!";
  }
}
