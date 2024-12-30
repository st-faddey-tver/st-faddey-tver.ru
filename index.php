<?php
include 'include/topscripts.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include 'include/head.php';
        ?>
    </head>
    <body>
        <?php
        include 'include/header.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <div class='row'>
                    <div class='col-12 col-md-6' style='background-image: url(https://st-faddey-tver.ru/images/content/eventschback.jpg); background-position: center; background-size: cover;'>
                        <div style='display:inline;'><img src='https://st-faddey-tver.ru/images/content/eventkrestdlyarasp700.png' style='height: 60px; vertical-align: top;' /></div>
                        <div class='d-none d-md-inline ponomar' style='font-size: 2.5rem;'><a href='/schedule/'>Расписание богослужений</a></div>
                        <div class='d-inline d-md-none ponomar' style='font-size: 1.5rem;'><a href='/schedule/'>Расписание богослужений</a></div>
                        <?php
                        $sql = "select sd.id sd_id, sd.date, "
                                . "sh.id sh_id, sh.name holiday, "
                                . "st.id st_id, st.time, st.endtime, st.temple_id, "
                                . "ss.id ss_id, ss.name service "
                                . "from schedule_date sd "
                                . "left join schedule_holiday sh on sh.schedule_date_id = sd.id "
                                . "left join schedule_time st on st.schedule_date_id = sd.id "
                                . "left join schedule_service ss on ss.schedule_time_id = st.id "
                                . "where sd.date >= curdate() "
                                . "order by sd.date desc, sh.id asc, st.time asc, st.endtime asc, ss.id asc";
                        $grabber = new Grabber($sql);
                        $schedule = $grabber->result;
                        $error_message = $grabber->error;
                            
                        $dates = array();
                            
                        foreach ($schedule as $row) {
                            $sd_id = $row['sd_id'];
                                
                            if(!empty($sd_id)) {
                                if(!array_key_exists($sd_id, $dates)) {
                                    $date = array();
                                    $date['id'] = $sd_id;
                                    $date['date'] = $row['date'];
                                    $date['holidays'] = array();
                                    $date['times'] = array();
                                    $dates[$sd_id] = $date;
                                }
                                else {
                                    $date = $dates[$sd_id];
                                }
                                    
                                $holidays = $date['holidays'];
                                $times = $date['times'];
                                    
                                $sh_id = $row['sh_id'];
                                    
                                if(!empty($sh_id)) {
                                    if(!array_key_exists($sh_id, $holidays)) {
                                        $holiday = array();
                                        $holiday['id'] = $sh_id;
                                        $holiday['holiday'] = $row['holiday'];
                                        $holidays[$sh_id] = $holiday;
                                        $date['holidays'] = $holidays;
                                        $dates[$sd_id] = $date;
                                    }
                                }
                                    
                                $st_id = $row['st_id'];
                                    
                                if(!empty($st_id)) {
                                    if(!array_key_exists($st_id, $times)) {
                                        $time = array();
                                        $time['id'] = $st_id;
                                        $time['time'] = $row['time'];
                                        $time['endtime'] = $row['endtime'];
                                        $time['temple_id'] = $row['temple_id'];
                                        $time['services'] = array();
                                        $times[$st_id] = $time;
                                        $date['times'] = $times;
                                        $dates[$sd_id] = $date;
                                    }
                                    else {
                                        $time = $times[$st_id];
                                    }
                                        
                                    $services = $time['services'];
                                    
                                    $ss_id = $row['ss_id'];
                                    
                                    if(!empty($ss_id)) {
                                        $service = array();
                                        $service['id'] = $ss_id;
                                        $service['service'] = $row['service'];
                                        $services[$ss_id] = $service;
                                        $time['services'] = $services;
                                        $times[$st_id] = $time;
                                        $date['times'] = $times;
                                        $dates[$sd_id] = $date;
                                    }
                                }
                            }
                        }
                        ?>
                        <table class="table table-sm">
                            <?php
                            $current_date = date("Y-m-d");
                            while($current_date == date("Y-m-d")):
                            $date = array_pop($dates);
                            if(!empty($date)):
                            $current_date = $date['date'];
                            $dDate = DateTime::createFromFormat ('Y-m-d', $date['date']);
                            ?>
                            <thead class="thead-light">
                                <tr>
                                    <th class="w-25 align-top"><?=$dDate->format('j ').$months_genitive[$dDate->format('n')].$dDate->format(' Y г.') ?></th>
                                    <th class="align-top">
                                        <?=$weekdays[$dDate->format("N")] ?>
                                        <?php foreach ($date['holidays'] as $holiday): ?>
                                        <div class="text-danger"><?=$holiday['holiday'] ?></div>
                                        <?php endforeach; ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody style="border-bottom: 1px solid #dee2e6;">
                                <?php
                                $old_temple = TEMPLE_FADDEY;
                                
                                foreach ($date['times'] as $time):
                                $tTime = DateTime::createFromFormat("H:i:s", $time['time']);
                                $tEndTime = null;
                                if(!empty($time['endtime'])) {
                                    $tEndTime = DateTime::createFromFormat("H:i:s", $time['endtime']);
                                }
                                $tTempleId = $time['temple_id'];
                                
                                $new_temple = $tTempleId;
                                if($new_temple != $old_temple):
                                ?>
                                <tr>
                                    <td class="w-25"></td>
                                    <td class="align-top" style="font-weight: bold; font-size: small; padding-top: .1rem; padding-bottom: .1rem; color: <?=TEMPLE_COLORS[$new_temple] ?>"><?=TEMPLE_NAMES[$new_temple] ?></td>
                                </tr>
                                <?php
                                $old_temple = $new_temple;
                                endif;
                                ?>
                                <tr>
                                    <td class="align-top w-25" style="color: <?=TEMPLE_COLORS[$tTempleId] ?>"><?=$tTime->format('H:i') ?><?= empty($tEndTime) ? '' : '&nbsp;&ndash;&nbsp;'.$tEndTime->format('H:i') ?></td>
                                    <td class="align-top" style="color: <?=TEMPLE_COLORS[$tTempleId] ?>">
                                        <?php foreach ($time['services'] as $service): ?>
                                        <div><?=$service['service'] ?></div>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <?php 
                            else:
                                $current_date = null;
                            endif;
                            endwhile;
                            ?>
                        </table>
                        <div class='text-right mb-4' style='clear: both;'><a href='/schedule/' class='btn btn-sm btn-light'>Расписание богослужений&nbsp;<i class='fas fa-angle-double-right'></i></a></div>
                    </div>
                    <div class='col-12 col-md-6 text-right'>
                        <div class="front_media">
                            <?php
                            $news_type_id = NEWS_TYPE_MEDIACENTER;
                            $sql = "select nf.body from news_fragment nf inner join news n on nf.news_id = n.id where n.news_type_id = $news_type_id and n.visible = 1 order by n.date desc, n.id desc limit 1";
                            $fetcher = new Fetcher($sql);
                                
                            if($row = $fetcher->Fetch()) {
                                echo str_replace('content', 'front_media', $row[0]);
                            }
                            ?>
                        </div>
                        <div class='text-right mb-4' style='clear: both;'><a href='/mediacenter/' class='btn btn-sm btn-light'>Медиацентр&nbsp;<i class='fas fa-angle-double-right'></i></a></div>
                    </div>
                </div>
                <?php
                $event_type_announcement = EVENT_TYPE_ANNOUNCEMENT;
                $sql = "select date, body from event where event_type_id = $event_type_announcement and visible = 1 and top = 1 order by date desc, id desc";
                $fetcher = new Fetcher($sql);
                
                while ($row = $fetcher->Fetch()):
                $date = $row['date'];
                $body = $row['body'];
                echo "<div class='events_body'>$body</div>";
                endwhile;
                ?>
                <div class="row">
                    <div class="col-12 col-md-8">
                        <?php
                        $sql = "select date, body from event where event_type_id = $event_type_announcement and visible = 1 and top = 0 order by date desc, id desc";
                        $fetcher = new Fetcher($sql);
                        
                        while ($row = $fetcher->Fetch()):
                        $date = $row['date'];
                        $body = $row['body'];
                        echo "<div class='events_body'>$body</div>";
                        endwhile;
                        ?>
                    </div>
                    <div class="col-12 col-md-4">
                        <?php
                        $news_type_id = NEWS_TYPE_NEWS;
                        $sql = "select date, name, shortname, body from news where news_type_id = $news_type_id and front = 1 and visible = 1 order by date desc, id desc";
                        $fetcher = new Fetcher($sql);
                        $news_count = 0;
                        
                        while ($row = $fetcher->Fetch()):
                        $date = $row['date'];
                        $name = $row['name'];
                        $shortname = $row['shortname'];
                        $body = $row['body'];
                        $news_count++;
                        ?>
                        <div>
                            <div class="news_date"><?= DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') ?></div>
                            <div class="news_name"><a href="<?=APPLICATION."/news/".$shortname ?>"><?=$name ?></a></div>
                            <div class="news_body"><a href="<?=APPLICATION."/news/".$shortname ?>"><?=$body ?></a></div>
                        </div>
                        <?php
                        endwhile;
                        if($news_count > 0) {
                            echo "<div class='text-right mb-4' style='clear: both;'><a href='".APPLICATION."/news/' class='btn btn-sm btn-light'>Все новости&nbsp;<i class='fas fa-angle-double-right'></i></a></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'include/footer.php';
        ?>
    </body>
</html>