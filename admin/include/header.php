<div class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?=APPLICATION ?>/">На главную</a>
            </li>
        </ul>
        <!--ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);">Выход&nbsp;<i class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul-->
        <form class="form-inline ml-auto" method="post">
            <label class="text-light"><?= filter_input(INPUT_COOKIE, LAST_NAME).' '. filter_input(INPUT_COOKIE, FIRST_NAME).' '. filter_input(INPUT_COOKIE, MIDDLE_NAME) ?></label>
            &nbsp;&nbsp;
            <button type="submit" class="btn btn-outline-light" id="logout_submit" name="logout_submit">Выход&nbsp;<i class="fas fa-sign-out-alt"></i></button>
        </form>
    </nav>
</div>