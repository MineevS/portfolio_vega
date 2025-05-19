<section id="sctn-1"> 
    <div class="elems">
        {query_header_page data="Собери свою собственную, кртую и неповтортмую, команду мечты"}
        <div class="container" style="margin: 2rem 0 2rem 0;" style="display: flex; flex-direction: row; gap: 30px; margin-top: 2rem; width: 100%;">
            <div style="display: flex; flex-direction: row; width: 70%; height: 2rem;">
                <div class="inputDiv">
                    <!-- onblur="hideInputSugToolTip()" -->
                    <input class="inputSearch" id="inputSearch" oninput="inputSugToolTip('{$ACTION}')">
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
                        <a href="#" onclick="order_sort.call(this, 'new', '{$ACTION}')">Новые</a>
                        <a href="#" onclick="order_sort.call(this, 'old', '{$ACTION}')">Старые</a>
                        <a href="#" onclick="order_sort.call(this, 'rel', '{$ACTION}')">Релевантные</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hrProject">
        <div class="container container-for-teams">
            {query_teams select="*" from="$tab_teams" orderby="id" limit="$SIZE_PAGE_TEAMS" offset="0"}
        </div>
        <cstm-load-data class="next-load" action='{$ACTION}'></cstm-load-data>
    </div>
</section>