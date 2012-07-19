  <thead>
    <tr>
      <td colspan=4 align="right">
        <?php if ($pager->haveToPaginate()): ?>
          <?php $u = $q==''?url_for('note/index').'?':url_for('note/index').'?q='.$q.'&'; ?>
          <span class="pagination">
            <a href="<?php echo $u ?>page=1">|&lt;</a>
            <a href="<?php echo $u ?>page=<?php echo $pager->getPreviousPage() ?>">&lt;</a>
            <?php foreach ($pager->getLinks() as $page): ?>
              <?php if ($page == $pager->getPage()): ?>
                <?php echo $page ?>
              <?php else: ?>
                <a href="<?php echo $u ?>page=<?php echo $page ?>"><?php echo $page ?></a>
              <?php endif; ?>
            <?php endforeach; ?>

            <a href="<?php echo $u ?>page=<?php echo $pager->getNextPage() ?>">&gt;</a>
            <a href="<?php echo $u ?>page=<?php echo $pager->getLastPage() ?>">&gt;|</a>
          </span>
        <?php endif; ?>
        <span class="pagination_desc">
          <strong><?php echo count($pager) ?></strong> notes found
          <?php if ($pager->haveToPaginate()): ?>
            - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
          <?php endif; ?>
        </span>
      </td>
    </tr>
  </thead>
  <tbody style='font-size:10pt'>
    <?php $notes=$pager->getResults();foreach ($notes as $note): ?>
    <tr>
      <td colspan=4 style='font-size:12pt;background:#88AAFF'><?php echo $note->getTitle() ?></td>
    </tr>
    <tr>
      <td><?php echo $note->getContent() ?></td>
      <td><?php echo $note->getTag() ?></td>
      <td><?php echo link_to('Delete', 'note/delete?id='.$note->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?></td>
      <td><a href="<?php echo url_for('note/index?id='.$note->getId()) ?>">Edit</a></td>
    </tr>
    <tr>
      <td colspan=4 align="right"><span>Created at <?php echo $note->getCreatedAt() ?></span><span align="right" style="margin-left:50px">Last updated at <?php echo $note->getUpdatedAt() ?></span></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
