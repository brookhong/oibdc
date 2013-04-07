<?php

/**
 * BMP form.
 *
 * @package    oibdc
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BMPForm extends BaseBMPForm
{
  public function configure()
  {
    unset( $this['created_at'], $this['updated_at']);
    $this->setDefault ('ip', $_SERVER['REMOTE_ADDR']);
    $this->setDefault ('content', '#include <stdio.h>
int main(int argc, char const* argv[])
{
    printf("hello, world!");
    return 0;
}');
  }
}
