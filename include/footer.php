<div class="container">
    <div class="footer">
        <div class="row">
            <div class="col-2">
                <table>
                    <tr>
                        <td style="vertical-align: top; padding-right: 10px;"><i class="far fa-copyright"></i></td>
                        <td style="padding-bottom: 10px;">Московская патриархия,<br />храм свмч. Фаддея архиепископа Тверского</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-right: 10px;"><i class="far fa-copyright"></i></td>
                        <td>Художник<br />Артём Петров<br />(картина в заголовке сайта)</td>
                    </tr>
                </table>
            </div>
            <div class="col-2">
                <p><a href="<?=APPLICATION ?>/">На главную</a></p>
                <p><a href="<?=APPLICATION ?>/pilgrimage/">Паломничество</a></p>
                <p><a href="<?=APPLICATION ?>/contact/">Контакты</a></p>
                <p><a href="<?=APPLICATION ?>/gallery/">Фотогалерея</a></p>
            </div>
            <div class="col-2">
                <p>О храме</p>
                <p><a href="<?=APPLICATION ?>/history/">История</a></p>
                <p><a href="<?=APPLICATION ?>/saints/">Святые храма</a></p>
                <p><a href="<?=APPLICATION ?>/schedule/">Расписание богослужений</a></p>
                <p><a href="<?=APPLICATION ?>/clergy/">Духовенство</a></p>
                <p><a href="<?=APPLICATION ?>/events/">Все события</a></p>
                <p><a href="<?=APPLICATION ?>/news/">Все новости</a></p>
            </div>
            <div class="col-2">
                <p>Молодёжь храма</p>
                <p><a href="<?=APPLICATION ?>/volunteer/">Добровольческое движение</a></p>
                <p><a href="<?=APPLICATION ?>/club/">Молодёжный клуб &laquo;Встреча&raquo;</a></p>
                <p><a href="<?=APPLICATION ?>/family/">Семейный клуб</a></p>
                <p><a href="<?=APPLICATION ?>/cinema/">Синематографический клуб</a></p>
            </div>
            <div class="col-2">
                <p>Воскресная школа</p>
                <p><a href="<?=APPLICATION ?>/sunday/schedule/">Расписание занятий</a></p>
                <p><a href="<?=APPLICATION ?>/sunday/documents/">Документы</a></p>
                <p><a href="<?=APPLICATION ?>/sunday/teachers/">Преподаватели</a></p>
            </div>
            <div class="col-2">
                <p>Курсы подготовки для поступления в семинарию</p>
                <p><a href="<?=APPLICATION ?>/preparation/schedule/">Расписание занятий</a></p>
                <p><a href="<?=APPLICATION ?>/preparation/documents/">Документы</a></p>
                <p><a href="<?=APPLICATION ?>/preparation/teachers/">Преподаватели</a></p>
            </div>
        </div>
    </div>
</div>
<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/popper.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.min.js'></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>