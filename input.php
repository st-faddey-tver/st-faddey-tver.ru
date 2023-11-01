<?php
include './include/topscripts.php';
$title = "Ввод";
$description = "Ввод на разных языках";
$keywords = "Ввод на разных языках";
?>
<html>
    <head>
        <?php
        include 'include/head.php';
        ?>
        <style>
            /* Виртуальная клавиатура */
            form {
                position: relative;
            }
            
            .rtl {
                direction: rtl;
            }
            
            /* Всплывающее сообщение о копировании ссылки */
.clipboard_alert {
    position: absolute;
    left: 20px;
    top: 100%;
    z-index: 100;
    display: none;
}

            .virtual_keyboard {
                width: 100%;
                background-color: lightgray;
                padding: 10px;
                position: relative;
            }

            .vk_close {
                position: absolute;
                top: 10px;
                right: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        include 'include/header.php';
        ?>
        <div class="container">    
            <form>
                <?php
                include './include/virtual_keyboard.php';
                ?>
                <div class="form-group">
                    <label for="body">Введите текст</label>
                    <textarea name="body" class="form-control" style="height: 200px;"></textarea>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-dark btn_vk"><i class="fas fa-keyboard"></i>&nbsp;Виртуальная клавиатура</button>
                </div>
            </form>
        </div>
        <?php
        include './admin/include/footer.php';
        ?>
    </body>
</html>