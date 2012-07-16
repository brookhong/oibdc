<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $note->getId() ?></td>
    </tr>
    <tr>
      <th>Title:</th>
      <td><?php echo $note->getTitle() ?></td>
    </tr>
    <tr>
      <th>Content:</th>
      <td><?php echo $note->getContent() ?></td>
    </tr>
    <tr>
      <th>Tag:</th>
      <td><?php echo $note->getTag() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $note->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $note->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('note/edit?id='.$note->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('note/index') ?>">List</a>
