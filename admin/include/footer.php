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
            bodyStyle: "margin:4px; font-size:1.2rem; font-family: Arial,Verdana, sans-serif; cursor:text"
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
    function RemoveCSLClasses(obj) {
        obj.removeClass('ponomar');
        obj.removeClass('fedorovsk');
        obj.removeClass('menaion');
        obj.removeClass('monomakh');
        obj.removeClass('cathisma');
        obj.removeClass('oglavie');
        obj.removeClass('fira');
        obj.removeClass('pochaevsk');
        obj.removeClass('triodion');
        obj.removeClass('acathist');
        obj.removeClass('shafarik');
        obj.removeClass('shafarik3');
        obj.removeClass('pomorsky-dropcaps');
        obj.removeClass('indiction-dropcaps');
        obj.removeClass('vertograd-dropcaps');
    }
    
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
            RemoveCSLClasses($('.vk_keys.slavic'));
            $('.vk_keys.slavic').addClass($(this).parent().next('.csl_font').children('select.vk_font').val());
        }
        else {
            $(this).parent().next('.csl_font').hide();
        }
        
        $('.vk_keys').hide();
        $('.vk_keys.' + $(this).val()).show();
    });
    
    $('.vk_font').change(function(){
        RemoveCSLClasses($('.vk_keys.slavic'));
        $('.vk_keys.slavic').addClass($(this).val());
    });
    
    var textelement = null;
    var body = null;
    
    //$(document).ready(function(){
        var frames = $('iframe').contents();
        
        frames.click(function(e) {
            textelement = e.target;
            if(textelement.nodeName == 'HTML') {
                textelement = textelement.children[1];
            };
            
            body = textelement.getRootNode().children[0].children[1];
        });
    //});
    
    $('.vk_btn').click(function(e){
        var form = $(e.target).parents('form');
        var ta = form.find('textarea');

        if(ta.is(':visible')) {
            ta.focus();
            var text = ta.text(); // alert(text);
            var selStart = ta.prop('selectionStart');
            var selEnd = ta.prop('selectionEnd');
            var textStart = text.substring(0, selStart);
            var textEnd = text.substring(selEnd);
            var newText = textStart + $(e.target).text() + textEnd;
            ta.text(newText);
            ta.prop('selectionStart', selStart + $(e.target).text().length);
            ta.prop('selectionEnd', selStart + $(e.target).text().length);
        }
        else if(textelement != null) {
            textelement.textContent += $(e.target).text(); // alert(body.innerHTML);
            ta.text(body.innerHTML);
        }
    });
    
    // Прокрутка на прежнее место после отправки формы
    $(window).on("scroll", function(){
        $('input[name="scroll"]').val($(window).scrollTop());
    });
    
    <?php if(!empty($_REQUEST['scroll'])): ?>
        window.scrollTo(0, <?php echo intval($_REQUEST['scroll']); ?>);
    <?php endif; ?>
</script>