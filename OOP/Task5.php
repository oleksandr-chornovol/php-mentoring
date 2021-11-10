<?php

class Salesman extends Person
{
  const occupation = 'Salesman';
  
  public function __construct($name, $age)
  {
    parent::__construct($name, $age, self::occupation);
  }
  
  public function introduce(): string
  {
    return parent::introduce() . ', don\'t forget to check out my products!';
  }
}

class ComputerProgrammer extends Person
{
  const occupation = 'Computer Programmer';

  public function __construct($name, $age)
  {
    parent::__construct($name, $age, static::occupation);
  }
  
  public function describe_job(): string
  {
    return parent::describe_job() . ', don\'t forget to check out my Codewars account ;)';
  }
}

class WebDeveloper extends ComputerProgrammer
{
  const occupation = 'Web Developer';
  
  public function __construct($name, $age)
  {
    parent::__construct($name, $age);
  }
  
  public function describe_job(): string
  {
    return parent::describe_job() . ' And don\'t forget to check on my website :D';
  }
  
  public function describe_website(): string
  {
    return 'My professional world-class website is made from HTML, CSS, Javascript and PHP!';
  }
}
