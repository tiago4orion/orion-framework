<?php /* Smarty version 2.6.23, created on 2009-07-29 14:08:05
         compiled from configAdmin.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="View/scriptaculo/ajax.js"></script>
<script type="text/javascript" src="View/scriptaculo/Admin/adminUI.js"></script>
<script type="text/javascript">
<?php echo '

	$j = jQuery.noConflict();
	$j(document).ready(function() {
'; ?>

		<?php if ($this->_tpl_vars['url'] == "Admin/Users/EditAdmin"): ?>
			populate('country', <?php echo $this->_tpl_vars['user']['country_id']; ?>
);
			<?php if ($this->_tpl_vars['user']['country_id'] == 76): ?>
			populate('state', <?php echo $this->_tpl_vars['user']['state_id']; ?>
, 76);
			populate('city', <?php echo $this->_tpl_vars['user']['city_id']; ?>
, <?php echo $this->_tpl_vars['user']['state_id']; ?>
);
			<?php else: ?>
			trocaDom(null, <?php echo $this->_tpl_vars['user']['country_id']; ?>
);
			<?php endif; ?>
		<?php else: ?>	
			populate('country', 76);
			populate('state',null, 76);
			populate('city', null, 26);
		<?php endif; ?>
<?php echo '
	});
	
	function aguarde() {
		alert(\'Área ainda em construção\');
		return false;
	}
</script>
'; ?>


</head>
<body>
	<div id="container">
    	<div id="header">
        	<div id="title"><h2>Hit Centre of Language</h2></title></div>
        	
        	<div id="account" name="account">
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/account.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        	</div>
    	<div id="topmenu">
        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/topmenu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
      </div>
        <div id="top-panel">
            <div id="panel">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/panel.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
      </div>
        <div id="wrapper">
            <div id="content">
            	<div id="box" name="box">
            		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "actions/Config/administrators.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            	</div>
            </div>
            <div id="sidebar">
  				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          </div>
      </div>
        <div id="footer">
        <div id="credits">

        </div>
        <div id="styleswitcher">
            <ul>
                <li><a href="javascript: document.cookie='theme='; window.location.reload();" title="Default" id="blueswitch">b</a></li>
                <li><a href="javascript: document.cookie='theme=1'; window.location.reload();" title="Blue" id="defswitch">d</a></li>
                <li><a href="javascript: document.cookie='theme=2'; window.location.reload();" title="Green" id="greenswitch">g</a></li>
                <li><a href="javascript: document.cookie='theme=3'; window.location.reload();" title="Brown" id="brownswitch">b</a></li>
                <li><a href="javascript: document.cookie='theme=4'; window.location.reload();" title="Mix" id="mixswitch">m</a></li>
            </ul>
        </div><br />

        </div>
</div>
</body>
</html>