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
        if (!$query = $request->getParameter('q')) {
            $this->q = "";
            $q = Doctrine_Core::getTable('note')->createQuery('a')->orderBy('updated_at DESC');
        }
        else {
            $this->q = $query;
            $hits = NoteTable::getLuceneIndex()->find($query);
            $pks = array();
            foreach ($hits as $hit) {
                $pks[] = $hit->pk;
            }
            if (empty($pks)) {
                $pks[] = -1;
            }
            $q = Doctrine_Core::getTable('note')->createQuery('j')->whereIn('j.id', $pks);
        }
        $this->pager = new sfDoctrinePager('note', sfConfig::get('app_max_notes_each_page'));
        $this->pager->setQuery($q);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();

        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('note/list', array('pager' => $this->pager, 'q'=>$this->q));
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        if($request->getParameter('id')) {
            $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
            $this->form = new NoteForm($note);
        }
        else {
            $this->form = new NoteForm();
        }
        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('note/form', array('form' => $this->form));
        }
        $this->redirect('note/index');
    }
    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new NoteForm();

        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        if ($this->form->isValid()) {
            $note = $this->form->save();

            $this->redirect('note/index');
        } else {
            return $this->renderPartial('note/form', array('form' => $this->form));
        }
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
        $this->form = new NoteForm($note);

        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        if ($this->form->isValid()) {
            $note = $this->form->save();

            $this->redirect('note/index');
        } else {
            return $this->renderPartial('note/form', array('form' => $this->form));
        }
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($note = Doctrine_Core::getTable('note')->find(array($request->getParameter('id'))), sprintf('Object note does not exist (%s).', $request->getParameter('id')));
        $note->delete();

        $this->redirect('note/index');
    }
}
