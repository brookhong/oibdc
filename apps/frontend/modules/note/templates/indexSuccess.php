<table width="80%">
  <tr>
    <td>
      <form action="<?php echo url_for('note/index')?>">
        <input type='text' name='q' value="<?php echo $q?>" id="search_input">
      </form>
    </td>
    <td align="right">
      <a href="javaScript:void(0);" onclick="javaScript:newForm(0);" class="new_note_link">New Note</a>
    </td>
  </tr>
  <tr>
    <td colspan=2 align="center">
      <div style="height:20px"><img id="loader" style="display:none" src="<?php echo image_path('loading.gif') ?>"/></div>
    </td>
  </tr>
</table>
<table class='note_list'>
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
      <td><a href="javaScript:void(0);" onclick="javaScript:newForm(<?php echo $note->getId() ?>);">Edit</a></td>
    </tr>
    <tr>
      <td colspan=4 align="right"><span>Created at <?php echo $note->getCreatedAt() ?></span><span align="right" style="margin-left:50px">Last updated at <?php echo $note->getUpdatedAt() ?></span></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script type="text/javaScript">
function newForm(id) {
  if(id == 0) {
    link = "<?php echo url_for('note/edit') ?>";
    title = "New Note";
  } else {
    link = "<?php echo url_for('note/edit') ?>?id="+id;
    title = "Edit Note";
  }
  $.ajax({
    url: link,
      success: function(data) {
        new Messi(data, {title: title, modal: true, width:'600px'});
        var l = $('#note_content').closest("td").width();
        $('#note_title').width(l);
        $('#note_content').width(l);
        $('#note_tag').width(l);
        $('#note_content').height(180);
        $('#note_content').select(function() {
          var ot = $('#note_tag').val().toString();
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
          $('#note_tag').val(ot.toString());
        });
      }
  });
}
$(document).ready(function() {
  $('#search_input').keyup(function(key) {
      if (this.value.length >= 3 || this.value == '') {
        $('#loader').show();
        $('.note_list').load($(this).parents('form').attr('action'), { q: this.value }, function() { $('#loader').hide(); });
      }
    });
});
</script>
