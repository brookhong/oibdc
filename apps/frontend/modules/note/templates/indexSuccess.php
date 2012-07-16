
<?php if (!$form->getObject()->isNew()): ?>
  <h1>Edit Note
  <a href="<?php echo url_for('note/index') ?>">New</a></h1>
<?php else: ?>
  <h1>New Note</h1>
<?php endif; ?>

<?php include_partial('form', array('form' => $form)) ?>

<h1>Notes List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Content</th>
      <th>Tag</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($notes as $note): ?>
    <tr>
      <td><?php echo $note->getId() ?></td>
      <td><?php echo $note->getTitle() ?></td>
      <td><?php echo $note->getContent() ?></td>
      <td><?php echo $note->getTag() ?></td>
      <td><?php echo $note->getCreatedAt() ?></td>
      <td><?php echo $note->getUpdatedAt() ?></td>
      <td><a href="<?php echo url_for('note/delete?id='.$note->getId()) ?>">Delete</a></td>
      <td><a href="<?php echo url_for('note/index?id='.$note->getId()) ?>">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
