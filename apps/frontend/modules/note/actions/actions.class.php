<?php

/**
 * note actions.
 *
 * @package    oibdc
 * @subpackage note
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class noteActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $q = Doctrine_Core::getTable('note')->createQuery('a');
    $this->pager = new sfDoctrinePager('note', sfConfig::get('app_max_notes_each_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    if($request->getParameter('id')) {
      $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
      $this->form = new noteForm($note);
    }
    else {
      $this->form = new noteForm();
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new noteForm();

    $this->processForm($request, $this->form);

    $this->notes = Doctrine_Core::getTable('note')->createQuery('a')->execute();
    $this->setTemplate('index');
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
    $this->form = new noteForm($note);

    $this->processForm($request, $this->form);

    $this->notes = Doctrine_Core::getTable('note')->createQuery('a')->execute();
    $this->setTemplate('index');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
    $note->delete();

    $this->redirect('note/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $note = $form->save();

      $this->redirect('note/index');
    }
  }
}
