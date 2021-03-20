<hr /><br /><br /><br />
<script src='<?=APPLICATION ?>/js/jquery-3.5.1.min.js'></script>
<script src='<?=APPLICATION ?>/js/popper.min.js'></script>
<script src='<?=APPLICATION ?>/js/bootstrap.min.js'></script>
<script src="<?=APPLICATION ?>/fancybox-master/dist/jquery.fancybox.min.js"></script>
<script src='<?=APPLICATION ?>/admin/cleditor/jquery.cleditor.js'></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('textarea.editor').cleditor({
            docCSSFile: '<?=APPLICATION ?>/admin/css/main.css',
            height: 350,
            bodyStyle: "margin:4px; font-size:18px; font-family: Arial,Verdana, sans-serif; cursor:text"
        }); //[0].focus();
    });
    
    // Подтверждение удаления
    $('button.confirmable').click(function(){
        return confirm('Действительно удалить?');
    });
    
    // Копирование ссылки
    $('.copy_src').click(function(e){
        var src = $(e.target).attr("data-src");
        
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(src).select();
        document.execCommand("copy");
        $temp.remove();
        
        var alert = $(this).children('.clipboard_alert');
        alert.slideDown(300, function(){
            $(this).slideUp(1000);
        });
    });
    
    // Валидация
    $('input').keypress(function(){
        $(this).removeClass('is-invalid');
    });
    
    $('select').change(function(){
        $(this).removeClass('is-invalid');
    });
    
    // Виртуальная клавиатура
    $('.virtual_keyboard').hide();
    $('.csl_font').hide();
    $('.vk_keys').hide();
    $('.vk_keys.russian').show();
    
    $('.btn_vk').click(function(){
        $(this).closest('form').children('.virtual_keyboard').toggle();
    });
    
    $('.vk_close').click(function(){
        $(this).closest('.virtual_keyboard').hide();
    });
    
    $('.vk_language').change(function(){
        if($(this).val() == 'slavic') {
            $(this).parent().next('.csl_font').show();
        }
        else {
            $(this).parent().next('.csl_font').hide();
        }
        
        $('.vk_keys').hide();
        $('.vk_keys.' + $(this).val()).show();
    });
    
    // Прокрутка на прежнее место после отправки формы
    $(window).on("scroll", function(){
        $('input[name="scroll"]').val($(window).scrollTop());
    });
    
    <?php if(!empty($_REQUEST['scroll'])): ?>
        window.scrollTo(0, <?php echo intval($_REQUEST['scroll']); ?>);
    <?php endif; ?>
</script>