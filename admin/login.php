<?php
include '../include/topscripts.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container">
            <div class="content">
                <?php
                if(!empty($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <div class="row" style="margin-top: 30px; margin-bottom: 50px;">
                    <div class="d-none d-md-block col-md-4"></div>
                    <div class="col-12 col-md-4">
                        <form method="post">
                            <div class="form-group">
                                <label for="login_username">Логин</label>
                                <input type="text" id="login_username" name="login_username" class="form-control" value="<?= filter_input(INPUT_POST, 'username') ?>" required="required" />
                                <div class="invalid-feedback">Логин обязательно</div>
                            </div>
                            <div class="form-group">
                                <label for="login_password">Пароль</label>
                                <input type="password" id="login_password" name="login_password" class="form-control" required="required" />
                                <div class="invalid-feedback">Пароль обязательно</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="login_submit" name="login_submit" class="btn btn-outline-dark">Войти&nbsp;<i class="fas fa-sign-in-alt"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-none d-md-block col-md-4"></div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
        <script>
            $(document).ready(function(){
                $('#login_username').focus();
            });
        </script>
    </body>
</html>