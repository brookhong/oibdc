<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div id="note_edit_div">
  <form action="<?php echo url_for('note/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> >
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
    <table style="width:100%">
      <tfoot>
        <tr>
          <td></td>
          <td align="center"> <input type="submit" value="Save" /> </td>
          <td></td>
        </tr>
      </tfoot>
      <tbody>
        <tr> <td colspan="3"><?php echo $form->renderGlobalErrors(); echo $form->renderHiddenFields(); ?></td> </tr>
        <tr>
          <td style="width:10%"> <?php echo $form['title']->renderLabel() ?> </td>
          <td style="width:80%"> <?php echo $form['title']->render() ?> </td>
          <td> <?php echo $form['title']->renderError() ?> </td>
        </tr>
        <tr>
          <td> <?php echo $form['content']->renderLabel() ?> </td>
          <td> <?php echo $form['content']->render() ?> </td>
          <td> <?php echo $form['content']->renderError() ?> </td>
        </tr>
        <tr>
          <td> <?php echo $form['tag']->renderLabel() ?> </td>
          <td> <?php echo $form['tag']->render() ?> </td>
          <td> <?php echo $form['tag']->renderError() ?> </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
