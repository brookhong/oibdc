
<?php if (!$form->getObject()->isNew()): ?>
  <h1>Edit Note
  <a href="<?php echo url_for('note/index') ?>">New</a></h1>
<?php else: ?>
  <h1>New Note</h1>
<?php endif; ?>

<?php include_partial('form', array('form' => $form)) ?>

<h1>Notes List</h1>

<table style='width:80%'>
  <tbody style='font-size:10pt'>
    <?php foreach ($notes as $note): ?>
    <tr>
      <td colspan=6 style='font-size:12pt;background:#88AAFF'><?php echo $note->getTitle() ?></td>
    </tr>
    <tr>
      <td><?php echo $note->getContent() ?></td>
      <td><?php echo $note->getTag() ?></td>
      <td><?php echo $note->getCreatedAt() ?></td>
      <td><?php echo $note->getUpdatedAt() ?></td>
      <td><?php echo link_to('Delete', 'note/delete?id='.$note->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>
      <td><a href="<?php echo url_for('note/index?id='.$note->getId()) ?>">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
