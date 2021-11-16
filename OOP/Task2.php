<?php

class Person 
{ 
  public function __construct(public string $first_name, public string $last_name) {}
  
  public function get_full_name(): string
  {
    return "$this->first_name $this->last_name"; 
  }
}
