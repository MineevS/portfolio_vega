<?php
/* Smarty version 5.5.0, created on 2025-05-19 13:16:32
  from 'file:C:\projects\project_portfolio\portfolioSerg_3\public/assets/frontend/mains/main_for_vacancies.php' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_682b050062dff4_36258934',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '078d12e16e5e114bc8b25b5f2d177eb96adbf07e' => 
    array (
      0 => 'C:\\projects\\project_portfolio\\portfolioSerg_3\\public/assets/frontend/mains/main_for_vacancies.php',
      1 => 1747649788,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_682b050062dff4_36258934 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\projects\\project_portfolio\\portfolioSerg_3\\public\\assets\\frontend\\mains';
?><section id="sctn-1"> 
    <div class="elems">
    <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_header_page')->handle(array('data'=>"Наши открытые, вакансии в команду, лучших разработчиков"), $_smarty_tpl);?>

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
        <!-- <div class="container search" style="">
            <div class="container-search"> -->
        <!--<span class="search">
                    <input class="search" type="search" placeholder="Поиск" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 15 15">
                        <path stroke="#858585" stroke-linecap="round" d="M10.698 10.59 14 14m-1.91-7.274c0 3.163-2.483 5.727-5.545 5.727C3.482 12.453 1 9.889 1 6.726 1 3.564 3.482 1 6.545 1c3.062 0 5.544 2.564 5.544 5.726Z"/>
                    </svg>
                </span>-->
        <!-- <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_input')->handle(array('for'=>"search"), $_smarty_tpl);?>

                <div style="position: relative;">
                    <button class="tags round">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" fill="none" viewBox="0 0 15 11">
                            <path stroke="#858585" stroke-linecap="round" stroke-linejoin="round" d="M1 10h6M1 5.5h9M1 1h13" />
                        </svg>
                    </button>
                    <button class="filter round" onclick="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 17 17">
                            <path stroke="#858585" stroke-linecap="round" stroke-linejoin="round" d="M2.722 2h11.556c.399 0 .722.328.722.734v1.163a.74.74 0 0 1-.211.519l-4.633 4.706a.74.74 0 0 0-.212.518v4.626a.725.725 0 0 1-.897.712l-1.444-.367a.732.732 0 0 1-.548-.712V9.64a.74.74 0 0 0-.211-.518L2.212 4.416A.74.74 0 0 1 2 3.897V2.734C2 2.328 2.323 2 2.722 2Z" />
                        </svg>
                    </button> -->
        <!--<iframe id="filter" class="frame-filter" style="position: fixed; top: 25%; left: 25%; width: 50%; background: #fff; border: 1px solid #d9d9d9;">
                    </iframe>-->
        <!-- <div id="filter" class="filter" style="">
                        <input type="checkbox" value="SQL" /> <label for="scales">SQL</label>
                        <input type="checkbox" value="C++" /> <label for="scales">C++</label>
                        <input type="checkbox" value="Python" /> <label for="scales">Python</label>
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
                <div id="tags" class="container"> -->
        <!--<label class="labelTag" style="">SQL--> <!-- padding-right: 5px; -->
        <!--<<button onclick="this.parentNode.remove();" class="buttonTag" style="display: auto;">--> <!-- hidden visibility: hidden; stroke="#F6F6F6" -->
        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="7 10 20 20">
                                <path stroke="#777" stroke-linecap="round" d="M10.903 14.904 15.5 19.5m0 0 4.597 4.596M15.499 19.5l4.597-4.596M15.499 19.5l-4.596 4.596"></path>
                            </svg>
                        </button>
                    </label>
                </div>
            </div>
        </div> -->
        <hr class="hrProject">
        <div class="container vacancies-container" style="display: flex;"> <!-- repid in main_for_index-->
            <?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('query_vacancies')->handle(array('select'=>"*",'from'=>((string)$_smarty_tpl->getValue('tab_vacancies')),'orderby'=>"id",'limit'=>((string)$_smarty_tpl->getValue('limit_vacancies')),'offset'=>"0"), $_smarty_tpl);?>

        </div>
    </div>
    <!--<div style=" height: auto; display: flex; align-items: center; justify-content: end; flex-direction: row; width: 100%; height: 10%; background-color: #EA5657;">
		<p>Посмотрите все наши проекты</p> 
		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
		</svg>
	</div>-->
</section><?php }
}
