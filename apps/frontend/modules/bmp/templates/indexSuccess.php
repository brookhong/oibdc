<?php
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if($lang == "zh") { ?>
    <ol>
    <li>输入任意你想隐藏在BMP图片中的文字。
    <li>然后点击提交按钮。
    <li>右键单击右边的图片，保持到本地磁盘。
    <li>用记事本打开，先选择编码为UTF-8，再点击旁边的打开按钮。
    </ol>
    <?php } else { ?>
    <ol>
    <li>Write anything that you would like to hide in a BMP file here.
    <li>Then click this button to generate a BMP file.
    <li>Right click on the image right side, and save it to your disk.
    <li>Open it with any text editor, what do you find?
    </ol>
    <?php } ?>

    <table width="100%">
        <tr>
        <td width="50%"><form method='post' accept-charset='UTF-8'> <?php echo $form->renderHiddenFields();echo $form['content']->render() ?> <input type=submit text='go'></form></td>
        <td width="50%"><img width="80%" height="80%" src="data:image/bmp;base64,<?php echo $bmpS->get_base64_data() ?>" /></td>
        </tr>
    </table>
    <div align="center">Inspired by <a href="http://intermediaware.com/blog/hack-of-the-day-hello-world-in-paint">this page</a>, created by <a href="https://github.com/brookhong">brook hong</a></div>
