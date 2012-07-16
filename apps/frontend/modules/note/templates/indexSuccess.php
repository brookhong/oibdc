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
      <td><a href="<?php echo url_for('note/show?id='.$note->getId()) ?>"><?php echo $note->getId() ?></a></td>
      <td><?php echo $note->getTitle() ?></td>
      <td><?php echo $note->getContent() ?></td>
      <td><?php echo $note->getTag() ?></td>
      <td><?php echo $note->getCreatedAt() ?></td>
      <td><?php echo $note->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('note/new') ?>">New</a>
