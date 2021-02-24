<hr /><br /><br /><br />
<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/popper.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.min.js'></script>
<script src='<?=APPLICATION ?>/admin/cleditor/jquery.cleditor.js'></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('textarea.editor').cleditor({
            docCSSFile: '<?=APPLICATION ?>/admin/css/main.css',
            height: 350,
            bodyStyle: "margin:4px; font-size:18px; font-family: Arial,Verdana, sans-serif; cursor:text"
        })[0].focus();
    });
    
    // Подтверждение удаления
    $('button.confirmable').click(function(){
        return confirm('Действительно удалить?');
    });
    
    // Прокрутка на прежнее место после отправки формы
    $(window).on("scroll", function(){
        $('input[name="scroll"]').val($(window).scrollTop());
    });
    
    <?php if(!empty($_REQUEST['scroll'])): ?>
        window.scrollTo(0, <?php echo intval($_REQUEST['scroll']); ?>);
    <?php endif; ?>
</script>