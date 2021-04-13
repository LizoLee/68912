<?php if (!isset ($index)) die()?>
<?php include_header("Отзывы");?>
        <div class="container">
            <h3>Форма отправки отзывов</h3>
            <p><span class="text-danger">* обязательное поле</span></p>
            <form action="" method="post" target="_self"
                  enctype="multipart/form-data">

                <?php if(isset($response) && $response != "Отзыв отправлен") { ?>

                <div class="form-row">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" 
                           value="<?php echo $form['name']?>" required>
                    <span class="text-danger">* </span>
                </div>
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" 
                           value="<?php echo $form['email']?>">
                </div>
                <div class="form-row">
                    <label for="mark">Оценка:</label>
                    <select size="1" id="mark" name="mark">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option selected value="5">5</option>
                    </select><span class="text-danger">* </span>
                </div>
                <div class="form-row">
                    <textarea rows="5" cols="40" name="comment" maxlength="200" 
                              placeholder="Текст отзыва"
                              ><?php echo $form['comment'] ?></textarea>
                </div>
                <div class="form-row">
                    <label for="picture">Фото:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1064960"/>
                    <input type="file" id="picture" name="picture[]" 
                           title="Загрузите одну или несколько фотографий" multiple>
                </div>
                <div class="form-row">
                    <span class="text-danger"><?php echo $response; ?></span>

                </div>
                <div class="form-row">
                    <input type="submit" value="Отправить">
                </div>

                <?php } else { ?>

                <div class="form-row">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" required>
                    <span class="text-danger">* </span>
                </div>
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email">
                </div>
                <div class="form-row">
                    <label for="mark">Оценка:</label>
                    <select size="1" id="mark" name="mark">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option selected value="5">5</option>
                    </select><span class="text-danger">* </span>
                </div>
                <div class="form-row">
                    <textarea rows="5" cols="40" name="comment" maxlength="200" 
                              placeholder="Текст отзыва"></textarea>
                </div>
                <div class="form-row">
                    <label for="picture">Фото:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1064960"/>
                    <input type="file" id="picture" name="picture[]" 
                           title="Загрузите одну или несколько фотографий" multiple>
                </div>

                <?php if(isset($response) && $response == "Отзыв отправлен") { ?>
                <div class="form-row">
                    <span class="mark"><?php echo $response; ?></span>
                </div>
                <?php } ?>

                <div class="form-row">
                    <input type="submit" value="Отправить">
                </div>

                <?php } ?>
            </form>
        </div>
<?php include_footer();?>