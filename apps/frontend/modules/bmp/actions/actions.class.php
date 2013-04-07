<?php

/**
 * bmp actions.
 *
 * @package    oibdc
 * @subpackage bmp
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
require_once sfConfig::get('sf_lib_dir')."/bmp/BMPSerializer.php";
class bmpActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new BMPForm();
    $content = $this->form->getDefault('content');
    if($request->isMethod(sfRequest::POST)) {
        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        if ($this->form->isValid()) {
            $this->form->updateObject();
            $content = $this->form->getValue('content');
            $this->form->getObject()->setip($_SERVER['REMOTE_ADDR']);
            $this->form->getObject()->save();
        }
    }
    $this->bmpS = new BMPSerializer();
    $this->bmpS->convert_from_string($content);
  }
}
