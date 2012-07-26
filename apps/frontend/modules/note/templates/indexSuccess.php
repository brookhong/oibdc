<table width="80%">
  <tr>
    <td>
      <form action="<?php echo url_for('note/index')?>">
        <input type='text' name='q' value="<?php echo $q?>" id="search_input" class="search" onblur="if(this.value != '')$(this).addClass('text');else $(this).removeClass('text');">
      </form>
    </td>
    <td>
      <?php if ($sf_user->isAuthenticated()): ?>
        <?php echo link_to('Logout', 'guard/logout', array('class'=>'button')) ?>
      <?php else: ?>
        <?php echo link_to('Login', 'guard/login', array('class'=>'button')) ?>
      <?php endif ?>
    </td>
    <td align="right">
      <a href="javaScript:void(0);" onclick="javaScript:newForm(this,0);" class="new_note_link button">New Note</a>
    </td>
  </tr>
  <tr>
    <td colspan=3 align="center">
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
      <td><?php echo link_to('Delete', 'note/delete?id='.$note->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'class'=>'button')) ?></td>
      <td><a href="javaScript:void(0);" onclick="javaScript:newForm(this, <?php echo $note->getId() ?>);" class='button'>Edit</a></td>
    </tr>
    <tr>
      <td colspan=4 align="right"><span>Created at <?php echo $note->getCreatedAt() ?></span><span align="right" style="margin-left:50px">Last updated at <?php echo $note->getUpdatedAt() ?></span></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script type="text/javaScript">
function on_form_ready(data) {
  $('#note_edit_td').html(data);
  $(".button").button();
  var l = $('#note_content').closest("td").width();
  $('#note_title').width(l);
  $('#note_tag').width(l);
  $('#note_content').width(l);
  $('#note_content').height(180);
  $('#note_content').select(function(e) {
    var at = $.trim(x.Selector.getSelected());
    $('#note_title').val(at);
  });
}
function on_form_save(e) {
  form = $(e).closest('form');
  $.post(form.attr('action'), form.serialize(),function(data) {
    if(data.indexOf('<div id="note_edit_div"') == 0) {
      on_form_ready(data);
    } else {
      $('.note_list').html(data);
      $(".button").button();
      $('#note_edit_td').closest('tr').remove();
    }
  });
}
function newForm(e,id) {
  tr = $(e).closest('tr');
  if(id == 0) {
    link = "<?php echo url_for('note/edit') ?>";
    title = "New Note";
  } else {
    link = "<?php echo url_for('note/edit') ?>?id="+id;
    title = "Edit Note";
  }
  $('#note_edit_td').closest('tr').remove();
  tr.after("<tr><td id='note_edit_td' colspan="+tr.children().length+" align='center'><img src=\"<?php echo image_path('loading.gif') ?>\"/></td></tr>");
  $.ajax({ url: link, success: on_form_ready});
}
$(document).ready(function() {
  $('#search_input').keyup(function(key) {
      if (this.value.length >= 3 || this.value == '') {
        $('#loader').show();
        $('.note_list').load($(this).parents('form').attr('action'), { q: this.value }, function() { $('#loader').hide(); $('.button').button();});
      }
    });
  $(".button").button();
});
</script>
