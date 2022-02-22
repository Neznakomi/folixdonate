<?php
/* Smarty version 3.1.30, created on 2020-04-09 21:09:12
  from "/var/www/user50598/data/www/moonpixel.ru/templates/messages.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e8f64c854bfd4_67047282',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '14263cacce625e3ce6653ebc84b30641e2625b66' => 
    array (
      0 => '/var/www/user50598/data/www/moonpixel.ru/templates/messages.html',
      1 => 1520156915,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e8f64c854bfd4_67047282 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages_list']->value, 'message');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['message']->value) {
if ($_smarty_tpl->tpl_vars['message']->value['err']) {?>
<div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong><strong>Ошибка!</strong> <?php echo $_smarty_tpl->tpl_vars['message']->value['text'];?>
</strong>
</div>
<?php } else { ?>
<div class="alert alert-dismissible alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong><strong>Успешно!</strong> <?php echo $_smarty_tpl->tpl_vars['message']->value['text'];?>
</strong>
</div>
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}
}
