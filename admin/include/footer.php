<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/popper.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.min.js'></script>
<script>
    // Всплывающая подсказка
    $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    // Подтверждение удаления
    $('button.confirmable').click(function(){
        return confirm('Действительно удалить?');
    });
</script>