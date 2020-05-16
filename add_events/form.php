 <form action='' method='post' enctype='multipart/form-data'>
 <section class="hero is-halfheight is-info has-bg-img">
        <img src="style/header_ev_create.jpg" class="is-back">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-size-2" style="color: azure;">Создание мероприятия</h1>
            </div>
        </div>
    </section>
    <div class="is-fullheight-with-navbar" style=" background:url(verh.png)  no-repeat; ">
        <div class="is-fullheight-with-navbar" style=" background-image:url(niz.png); background-repeat: no-repeat; background-position: bottom right;">

            <div class="hero is-small" style="padding: 0 10%;">
                <div class="hero-body">
                    <div class="slid">


                        <a>
                            <figure class="is-halfheight has-ratio " width="640" height="360" style="padding-left: 20%; padding-right: 20%">
								<input id='upload_file' name='userfile'  type='file' required>
                                <div id="image_preview" class="upload_preview"></div>
                            </figure>
                        </a>
                    </div>

                    <style type="text/css">
                        .label {
                            margin-top: 5px;
                        }
                    </style>

                </div>
            </div>


            <section class="container" style="padding: 0 10%;">
                <div class="columns is-gapless is-multiline is-mobile" style="margin-right: 10%;">

                    <div class="column is-narrow">
                        <label class="label">Название:&nbsp;</label>
                    </div>
                    <div class="column is-auto">
                        <input class="input" placeholder="Название мерроприятия" name='event_name' type='text' required>
                    </div>
                </div>
                <div class="columns is-gapless is-multiline is-mobile">

                    <div class="column is-auto">
                        <label class="label has-text-left">Даты проведения:</label>
                    </div>
                </div>
                <div class="columns is-gapless is-multiline is-mobile ">
                    <div class="column is-auto">
                        <div class="columns is-gapless is-multiline is-mobile">
                            <div class="column is-auto">
                                <div class="columns is-gapless  ">
                                    <div class="column is-auto">
                                        <label class="label">Начало:</label>
                                    </div>
                                    <div class="column is-auto">
                                        <input type='date' name='start_date'>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-auto">
                                <div class="columns is-gapless  ">
                                    <div class="column is-auto">
                                        <label class="label">Окончание:</label>
                                    </div>
                                    <div class="column is-auto">
                                        <input type='date' name='end_date'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-auto">

                    </div>
                </div>


                <div class="columns is-gapless is-multiline is-mobile">

                    <div class="column is-auto">
                        <label class="label has-text-left">Время проведения:</label>
                    </div>
                </div>

                <div class="columns is-gapless is-multiline is-mobile ">
                    <div class="column is-auto">
                        <div class="columns is-gapless is-multiline is-mobile">
                            <div class="column is-auto">
                                <div class="columns is-gapless  ">
                                    <div class="column is-auto">
                                        <label class="label">Начало:</label>
                                    </div>
                                    <div class="column is-auto">
                                        <input type='time' name='start_time'>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-auto">
                                <div class="columns is-gapless  ">
                                    <div class="column is-auto">
                                        <label class="label">Окончание:</label>
                                    </div>
                                    <div class="column is-auto">
                                        <input type='time' name='end_time'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-auto">

                    </div>
                </div>


                <div class="columns is-gapless is-multiline is-mobile" style="margin-right: 10%;">
                    <div class="column is-narrow">
                        <label class="label">Тема:&nbsp;</label>
                    </div>
                    <div class="column is-auto">
                        <div class="control is-fullwidth">
                            <div class="select is-fullwidth">
                                <select name='subject'>
							<?php
					include_once('../functions/ajax_api.php');
					$sub=get_subjects();
					foreach($sub as $value=>$text){
					  echo"<option value='".$value."'>".$text."</option>";
					}
					?>



                      </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns is-gapless is-multiline is-mobile" style="margin-right: 10%;">
                    <div class="column is-narrow">
                        <label class="label">О мероприятии:&nbsp;</label>
                    </div>

                </div>
                <div class="field-body" style="margin-bottom: 20px ; margin-right: 10%;">
                    <div class="field">
                        <div class="control">
                            <textarea name='data' class="textarea" placeholder="Расскажите о вашем мероприятии"></textarea>
                        </div>
                    </div>
                </div>



                <div class="columns  is-gapless is-multiline is-mobile" style="padding: 0 10%; margin-left: 10%; margin-right: 10%;">
                    <div class="column ">
                        <label class="label has-text-centered" style="margin-top: 15px;">Опубликовать для:&nbsp;</label>
                    </div>
                    <div class="column ">
                        <div class="button is-link is-rounded" id="btnAll" style="margin: 10px;">&nbsp;&nbsp;&nbsp;Всех&nbsp;&nbsp;&nbsp;</div>
                    </div>
                    <div class="column ">
                        <div class="button is-link is-rounded" id="btng" style="margin: 10px;">Группы</div>
                        <div id="sel" class="control">
                            <div class="select">
                                <select name='chat_id'>
                                <option value='none'>Select dropdown</option><!--Сюда айди чатав-->>
                                	<?php
										$id=get_id_by_session($_COOKIE['session'],$_COOKIE['token']);
										$chats=json_decode(own_chats_by_user_id($id));
										foreach($chats as $value){
										  echo"<option value='".$value."'>ЧАТ_id ".$value."</option>";
										}
									?>
                              </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns is-centered" style="padding: 0 23%; margin-left: 0.1%;">
                    <div class="column">
                        <input type='submit' class="button is-link is-rounded is-size-5" style="margin-top: -8px; background-color: #76c023;" value='Создать'>
                    </div>
                    <div class="column">
                        <a href='#' class=" label  is-size-6 has-text-centered" style=" color: #a2e76a; margin-top: 10px ; ">Сохранить как черновик</a>
                    </div>

                </div>
        </div>
        </section>
    </div>
    </div>
    </form>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        upload_file.onclick = function() {

        }

        $(function() {

            $('#upload_file').change(function() {

                var f = this.files,
                    i, r = new RegExp(this.accept.replace(/,/g, '|')),
                    b = $('#image_preview');

                for (i = 0; i < f.length; ++i) {

                    if (r.test(f[i].type)) b.append("<img class='thumb' src='" + URL.createObjectURL(f[i]) + "'>");

                }

            });

        });



        window.addEventListener('load', function() {
            new Glider(document.querySelector('.glider'), {
                slidesToShow: 1,

                draggable: true,
                dots: ".dots ",
                arrows: {
                    prev: ".glider-prev ",
                    next: ".glider-next "
                }
            })


        })
        btnAll.style.backgroundColor = "#3273dc";
        btng.style.backgroundColor = "#dfdfdf";
        btng.style.color = "#363644";
        btnAll.style.color = "white";
        sel.style.display = "none";
        btng.onclick = function() {
            btng.style.backgroundColor = "#3273dc";
            btnAll.style.backgroundColor = "#dfdfdf";
            btnAll.style.color = "#363644";
            btng.style.color = "white";
            sel.style.display = "flex";
        }

        btnAll.onclick = function() {
            btnAll.style.backgroundColor = "#3273dc";
            btng.style.backgroundColor = "#dfdfdf";
            btng.style.color = "#363644";
            btnAll.style.color = "white";
            sel.style.display = "none";

        }
    </script>se
