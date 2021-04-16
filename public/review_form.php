<?php
if (!isset($index)) {
    header("Location: /");
    die();
}
?>
<?php include_header(["title" => "Отзывы"]); ?>
<div class="container">
    <?php if ($user["authorized"]) { ?>
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Написать отзыв</h3>
                    <p><span class="text-danger">* обязательное поле</span></p>
                </div>
            </div>
            <div class="modal-body" style="position: relative;">
                <form action="" method="post" target="_self"
                      enctype="multipart/form-data">
                    <input type="hidden" name="form" value="review">
                    <div class="form-group row">
                        <div class="person-data col-left">
                            <label class="col-form-label" for="review-name"
                                   >Имя<span class="text-danger"> *</span></label>
                            <input type="text" id="review-name" class="form-control"
                                   name="name" placeholder="Имя" maxlength="100"
                                   value="<?php echo $user["name"] ?>" readonly>
                        </div><!--
                        --><div class="person-data col-right">
                            <label class="col-form-label" for="review-email">Email</label>
                            <input type="text" id="review-email" class="form-control"
                                   name="email" placeholder="Email"  maxlength="100"
                                   value="<?php echo $user["email"] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="review-rating">Оценка:</label>
                        <select size="1" id="review-rating" name="rate">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option selected value="5">5</option>
                        </select><span class="text-danger">* </span>
                    </div>

                    <?php if (isset($response) && $response != "Отзыв отправлен") { ?>
                        <div class="form-group row">
                            <label class="col-form-label" for="review-text">Комментарий</label>
                            <textarea id="review-text" class="form-control"
                                      name="comment" placeholder="Текст отзыва"
                                      ><?php echo $form["comment"] ?></textarea>
                        </div>
                        <div class="form-group row">
                            <label for="review-picture">Фото:</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1064960"/>
                            <input type="file" id="review-picture" name="picture[]" 
                                   title="Загрузите одну или несколько фотографий" multiple>
                        </div>
                        <div class="form-group row">
                            <span class="text-danger"><?php echo $response; ?></span>
                        </div>

                    <?php } else { ?>
                        <div class="form-group row">
                            <label class="col-form-label" for="review-text">Комментарий</label>
                            <textarea id="review-text" class="form-control"
                                      name="comment"></textarea>
                        </div>
                        <div class="form-group row">
                            <label for="review-picture">Фото:</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1064960"/>
                            <input type="file" id="review-picture" name="picture[]" 
                                   title="Загрузите одну или несколько фотографий" multiple>
                        </div>

                        <?php if (isset($response) && $response == "Отзыв отправлен") { ?>
                            <div class="form-row">
                                <span class="mark"><?php echo $response; ?></span>
                            </div>
                        <?php } ?>

                    <?php } ?>

                    <div class="form-group row">
                        <input type="submit" value="Отправить">
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix" style="height:15px;"></div>
    <?php } ?>

    <?php if (!empty($db_reviews) && is_array($db_reviews)) { ?>
        <div class="modal-content">
            <div class="modal-header">
                <h3>Отзывы пользователей</h3>
            </div>                
            <div class="modal-body" style="position: relative;">
                <?php foreach ($db_reviews as $db_review) { ?>
                    <div class="container-reviews">
                        <div class="author">
                            <span><?php echo $db_review["name"] ?></span>, 
                            <span><?php echo $db_review["date_insert"] ?></span>
                        </div>
                        <div class="stars-rating">
                            <?php $fill = "#ff9933"; ?>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <?php if ($i > $db_review["rate"]) $fill = "#dddddd"; ?>
                                <svg fill="<?php echo $fill ?>" height="20" width="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                </svg>
                            <?php } ?>
                        </div>
                        <div class="clearfix" style="height:15px;"></div>
                        <p><?php echo $db_review["text"] ?></p>
                        <?php if ($db_review["image_path"]) { ?>
                            <?php foreach ($db_review["image_path"] as $img) { ?>
                                <a href="<?php echo $img ?>"><img class="reviews-img" src="<?php echo $img ?>" alt="img"></a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<div class="clearfix" style="height:15px;"></div>
<?php include_footer(); ?>