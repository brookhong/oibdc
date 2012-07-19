<?php if (!$form->getObject()->isNew()): ?>
  <h1>Edit Note</h1>
<?php else: ?>
  <h1>New Note</h1>
<?php endif; ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('note/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> >
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table style="width:100%">
    <tfoot>
      <tr>
        <td> <input type="submit" value="Save" /> </td>
        <td></td>
        <td> <input type="button" value="Cancel" onclick="javaScript:$('#note_edit_div').addClass('display_none');" /> </td>
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
<script type="text/javaScript">
$('#<?php echo $form['content']->renderId()?>').select(function() {
    var ot = $('#<?php echo $form['tag']->renderId()?>').val().toString();
    if (ot != "")
        ot = ot.split(",");
    else
        ot = [];
    var at = x.Selector.getSelected().split(",");
    for(i=0; i<at.length; i++) {
        j = ot.indexOf(at[i]);
        if (j != -1) {
            ot.splice(j, 1);
        } else {
            ot.push(at[i]);
        }
    }
    $('#<?php echo $form['tag']->renderId()?>').val(ot.toString());
});
</script>
