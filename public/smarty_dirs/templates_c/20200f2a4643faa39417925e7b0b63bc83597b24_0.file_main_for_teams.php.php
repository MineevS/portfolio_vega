<?php
/* Smarty version 5.5.0, created on 2025-05-19 13:24:49
  from 'file:C:\projects\project_portfolio\portfolioSerg_3\public/assets/frontend/mains/main_for_teams.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_682b06f1130349_82562013',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '20200f2a4643faa39417925e7b0b63bc83597b24' => 
    array (
      0 => 'C:\\projects\\project_portfolio\\portfolioSerg_3\\public/assets/frontend/mains/main_for_teams.php',
      1 => 1747650285,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_682b06f1130349_82562013 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\projects\\project_portfolio\\portfolioSerg_3\\public\\assets\\frontend\\mains';
?><section id="sctn-1"> 
    <div class="elems">
        <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_header_page')->handle(array('data'=>"Собери свою собственную, кртую и неповтортмую, команду мечты"), $_smarty_tpl);?>

        <div class="container" style="margin: 2rem 0 2rem 0;" style="display: flex; flex-direction: row; gap: 30px; margin-top: 2rem; width: 100%;">
            <div style="display: flex; flex-direction: row; width: 70%; height: 2rem;">
                <div class="inputDiv">
                    <!-- onblur="hideInputSugToolTip()" -->
                    <input class="inputSearch" id="inputSearch" oninput="inputSugToolTip('<?php echo $_smarty_tpl->getValue('ACTION');?>
')">
                    </input>
                    <!-- <div class="inputSug">
                        <ul class="inputSugUi" id="inputSugUi">
                        </ul>
                    </div> -->
                </div>
                <button class="buttonCard">
                    <svg width="16" height="16">
                        <use xlink:href="#search_btn"></use>
                    </svg>
                </button>
                <!-- <div class="dropdown">
                    <button class="dropbtn">
                        <svg width="16" height="16">
                            <use xlink:href="#funnel_btn"></use>    
                        </svg>
                    </button>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </div> -->
                <div class="dropdown">
                    <button class="dropbtn">
                        <svg width="16" height="16">
                            <use xlink:href="#filter_btn"></use>     
                        </svg>
                    </button>
                    <div class="dropdown-content">
                        <a href="#" onclick="order_sort.call(this, 'new', '<?php echo $_smarty_tpl->getValue('ACTION');?>
')">Новые</a>
                        <a href="#" onclick="order_sort.call(this, 'old', '<?php echo $_smarty_tpl->getValue('ACTION');?>
')">Старые</a>
                        <a href="#" onclick="order_sort.call(this, 'rel', '<?php echo $_smarty_tpl->getValue('ACTION');?>
')">Релевантные</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hrProject">
        <div class="container container-for-teams">
            <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_teams')->handle(array('select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_teams')),'orderby'=>"id",'limit'=>((string)$_smarty_tpl->getValue('SIZE_PAGE_TEAMS')),'offset'=>"0"), $_smarty_tpl);?>

        </div>
        <cstm-load-data class="next-load" action='<?php echo $_smarty_tpl->getValue('ACTION');?>
'></cstm-load-data>
    </div>
</section><?php }
}
