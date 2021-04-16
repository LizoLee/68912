<?php
if (!isset($index)) {
    header("Location: /");
    die();
}
?>

<?php
if (isset($_GET["log_in"])) {
    include_header(["title" => "Вход"]);
    ?>
    <div class="container">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Вход</h3>
                </div>
            </div>
            <div class="modal-body" style="position: relative;">
                <form action="" method="post" target="_self">
                    <input type="hidden" name="form" value="log_in">
                    <?php if (isset($response)) { ?>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="text" class="form-control"
                                       name="email" placeholder="Email" maxlength="100"
                                       value="<?php echo $auth_form["email"] ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="password" class="form-control"
                                       name="password" placeholder="Пароль"
                                       maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="text-danger"><?php echo $response; ?></span>
                        </div>
                    <?php } else { ?>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="text" class="form-control"
                                       name="email" placeholder="Email" maxlength="100"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="password" class="form-control"
                                       name="password" placeholder="Пароль"
                                       maxlength="100" required>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group row">
                        <input type="submit" value="Войти">
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix" style="height:15px;"></div>
    </div>
    <?php
} elseif (isset($_GET["register"])) {
    include_header(["title" => "Регистрация"]);
    ?>
    <div class="container">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Регистрация</h3>
                </div>
            </div>
            <div class="modal-body" style="position: relative;">
                <form action="" method="post" target="_self">
                    <input type="hidden" name="form" value="register">

                    <?php if (isset($response)) { ?>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="text" class="form-control"
                                       name="name" placeholder="Имя" maxlength="100"
                                       value="<?php echo $auth_form["name"] ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="text" class="form-control"
                                       name="email" placeholder="Email"  maxlength="100"
                                       value="<?php echo $auth_form["email"] ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="password" class="form-control"
                                       name="password" placeholder="Пароль"  maxlength="100"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="password" class="form-control"
                                       name="password_confirm" placeholder="Повторите пароль"
                                       maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="text-danger"><?php echo $response; ?></span>
                        </div>

                    <?php } else { ?>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="text" class="form-control"
                                       name="name" placeholder="Имя" maxlength="100"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="text" class="form-control"
                                       name="email" placeholder="Email"  maxlength="100"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="password" class="form-control"
                                       name="password" placeholder="Пароль"  maxlength="100"
                                       required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="person-data authentication">
                                <input type="password" class="form-control"
                                       name="password_confirm" placeholder="Повторите пароль"
                                       maxlength="100" required>
                            </div>
                        </div>

                        <?php if (isset($response) && $response == "Отзыв отправлен") { ?>
                            <div class="form-row">
                                <span class="mark"><?php echo $response; ?></span>
                            </div>
                        <?php } ?>

                    <?php } ?>

                    <div class="form-group row">
                        <input type="submit" value="Зарегистрироваться">
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix" style="height:15px;"></div>
    </div>
<?php } ?>