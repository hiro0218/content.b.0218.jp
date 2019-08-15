<?php

class FrontVariables
{
  private function get_categories_exclude()
  {
    $exclude_category = (int) get_option('kiku_exclude_category_frontpage');
    return $exclude_category ? $exclude_category : 0;
  }
}

$fv = new FrontVariables();
