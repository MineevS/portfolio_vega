<?php
/* Smarty version 5.5.0, created on 2025-05-18 11:51:31
  from 'file:C:\xampp\htdocs\portfolio\public/assets/frontend/mains/main_for_projects.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_6829ada358a883_10142911',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e0e63a8f5df346ac408131546c7dfa93df9dbb63' => 
    array (
      0 => 'C:\\xampp\\htdocs\\portfolio\\public/assets/frontend/mains/main_for_projects.php',
      1 => 1747559974,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6829ada358a883_10142911 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\portfolio\\public\\assets\\frontend\\mains';
?><section id="sctn-1" style="display: grid;"> <!-- style="width: 100%;" -->
    <div class="elems">
        <article style="display: grid; width: 75%; justify-self: center;">
            <h1 class="HelveticaProject" style="justify-self: start;">Представляем вам</h1>
            <p class="VasekProject" style="justify-self: center;">лучшие проекты</p>
            <h1 class="HelveticaProject" style="justify-self: end;">базовой кафедры</h1>
        </article>

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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"></path>
                    </svg>
                </button>
                <div class="dropdown">
                    <button class="dropbtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z" />
                        </svg></button>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="dropbtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-left" viewBox="0 0 16 16">
                            <path d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                        </svg></button>
                    <div class="dropdown-content">
                        <a href="#" onclick="order_sort.call(this, 'new', '<?php echo $_smarty_tpl->getValue('ACTION');?>
')">Новые</a>
                        <a href="#" onclick="order_sort.call(this, ('old', '<?php echo $_smarty_tpl->getValue('ACTION');?>
')">Старые</a>
                        <a href="#" onclick="order_sort.call(this, ('rel', '<?php echo $_smarty_tpl->getValue('ACTION');?>
')">Релевантные</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hrProject">
        <div id="projects" class="container container-for-projects">
            <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_projects')->handle(array('select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_projects')),'orderby'=>"id",'limit'=>((string)$_smarty_tpl->getValue('SIZE_PAGE_PROJECTS')),'offset'=>"0"), $_smarty_tpl);?>

        </div>
        <cstm-load-data class="next-load" action='<?php echo $_smarty_tpl->getValue('ACTION');?>
'></cstm-load-data>
    </div>
</section><?php }
}
