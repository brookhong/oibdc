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
    $this->notes = Doctrine_Core::getTable('note')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->note);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new noteForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new noteForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
    $this->form = new noteForm($note);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
    $this->form = new noteForm($note);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
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

      $this->redirect('note/edit?id='.$note->getId());
    }
  }
}
