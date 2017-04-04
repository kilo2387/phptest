<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/23
 * Time: 0:23
 */


/*  开启短标记:short_open_tag */

/* 4种php标记:   纯php   =>   <?php
                html    =>  <?php ?>
                短标记   =>  <? ?>
                asp分格  =>   <% %>
                <script language="php"> </script>
*/

$expression = false;
?>




<?php if ($expression == false): ?>
    /* 高级分离 */
    This will show if the expression is true.
<?php else: ?>
    Otherwise this will show.
<?php endif; ?>

<?php
$file_contents  = '<?php die(); ?>' . "\n"; //注释有问题
?>

<?php
$file_contents  = '<' . '?php die(); ?' . '>' . "\n";
?>
