<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-2">
                <table>
                    <tr>
                        <td style="vertical-align: top; padding-right: 10px;"><i class="far fa-copyright"></i></td>
                        <td style="padding-bottom: 10px;">Московская патриархия,<br />храм свмч. Фаддея архиепископа Тверского</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-right: 10px;"><i class="far fa-copyright"></i></td>
                        <td style="padding-bottom: 10px;">Художник<br />Артём Петров<br />(картина в заголовке сайта)</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-right: 10px;"><i class="far fa-copyright"></i></td>
                        <td>Дмитрий Пантелеичев<br />(разработка сайта)</td>
                    </tr>
                </table>
            </div>
            <div class="d-none d-lg-block col-lg-2">
                <p><a href="<?=APPLICATION ?>/">На главную</a></p>
                <p><a href="<?=APPLICATION ?>/sunday/">Воскресная школа</a></p>
                <p><a href="<?=APPLICATION ?>/pilgrimage/">Паломничество</a></p>
                <p><a href="<?=APPLICATION ?>/contact/">Контакты</a></p>
                <p><a href="<?=APPLICATION ?>/donation/">Пожертвовать</a></p>
            </div>
            <div class="d-none d-lg-block col-lg-2">
                <p>О храме</p>
                <p><a href="<?=APPLICATION ?>/history/">История</a></p>
                <p><a href="<?=APPLICATION ?>/schedule/">Расписание богослужений</a></p>
                <p><a href="<?=APPLICATION ?>/clergy/">Духовенство</a></p>
                <p><a href="<?=APPLICATION ?>/news/">Все новости</a></p>
            </div>
            <div class="d-none d-lg-block col-lg-2">
                <p>Святые храма</p>
                <p><a href="<?=APPLICATION ?>/vera_truks/">Вера Трукс</a></p>
                <p><a href="<?=APPLICATION ?>/ilya_benemansky/">Илья Бенеманский</a></p>
                <p><a href="<?=APPLICATION ?>/ilya_gromoglasov/">Илья Громогласов</a></p>
                <p><a href="<?=APPLICATION ?>/nikolay_maslov/">Николай Маслов</a></p>
                <p><a href="<?=APPLICATION ?>/faddey_uspensky/">Фаддей Успенский</a></p>
            </div>
            <div class="d-none d-lg-block col-lg-2">
                <p>Святыни храма</p>
                <p><a href="<?=APPLICATION ?>/st_spyridon/">Икона св. Спиридона</a></p>
                <p><a href="<?=APPLICATION ?>/st_alexander_nevsky/">Икона св. Ал. Невского</a></p>
            </div>
            <div class="d-none d-lg-block col-lg-2">
                <p>Молодёжь храма</p>
                <p><a href="<?=APPLICATION ?>/volunteer/">Добровольческое движение</a></p>
                <p><a href="<?=APPLICATION ?>/theater/">Детская театральная студия &laquo;Раёк&raquo;</a></p>
                <p><a href="<?=APPLICATION ?>/club/">Молодёжный клуб &laquo;Встреча&raquo;</a></p>
                <p><a href="<?=APPLICATION ?>/family/">Семейный клуб</a></p>
                <p><a href="<?=APPLICATION ?>/cinema/">Синематографический клуб</a></p>
            </div>
        </div>
        <div class="informers mt-3">
            <!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=75082543&amp;from=informer"
target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/75082543/3_0_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="75082543" data-lang="ru" /></a>
<!-- /Yandex.Metrika informer -->
            <!--LiveInternet logo-->
            <a href="https://www.liveinternet.ru/click" target="_blank">
                <img src="https://counter.yadro.ru/logo?11.6" title="LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня" alt="" style="border:0" width="88" height="31"/>
            </a>
            <!--/LiveInternet-->
        </div>
    </div>
</div>
<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/popper.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.min.js'></script>
<script src="<?=APPLICATION ?>/fancybox-master/dist/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    $('.dropdown-item.dropdown-toggle').click(function(event){
        event.stopPropagation();
        $(this).next('.dropdown-menu').toggleClass('show');
    });
    
    var topHeight = $('#top').innerHeight();
    
    $(window).on('resize', function(){
        topHeight = $('#top').innerHeight();
        $(window).trigger('scroll');
    });
    
    navbarHideable = $('#navbar_hideable');
    
    $(window).scroll(function(){
        var navbarPosition = topHeight - $(window).scrollTop();
        
        // Удержание верхнего меню в верхней части экрана
        if(navbarPosition < 0) {
            if(!navbarHideable.is(':visible')) {
                navbarHideable.slideDown();
            }
        }
        else {
            if(navbarHideable.is(':visible')) {
                navbarHideable.slideUp();
            }
        }
    });
</script>