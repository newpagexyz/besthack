<section class="hero is-info">
        <div class="hero-body">
            <div class="container">
            </div>
        </div>
    </section>

    <div class="is-fullheight-with-navbar" style=" background:url(verh.png)  no-repeat; padding-top: 5%;  ">

        <section class="container " style="margin-top: -2%; padding:0 10% ; ">

            <p class="title " style="text-align: center; margin: 0 0 50px; ">Ваш профиль</p>
            <div class="columns is-centered ">

                <div class="column is-auto ">
                    <figure class="image is-rounded ">

                        <input class="file-input is-rounded " type="file " id="upload_file " name="upload_file[] " multiple=" " accept="image/jpeg,image/png,image/gif " />
                        <img id="_image " src="
							<?php 
								if($arr['image']!=null or $arr['image']!=false){
									echo"../public_image/user_av/".$arr['image'];
								}
								else{
									echo"../public_image/default/no_img.png";
								}
                        ?>">
                        <div id="image_preview " class="upload_preview "></div>
                    </figure>
                    <form action='' method='post' enctype='multipart/form-data'>
					<input name='userfile' type='file' required>
					<input type='submit' value='поменять'>
					</form>
					<form action='' method='post'>
                    <script>
                        $(function() {

                            $('#upload_file').change(function() {
                                _image.style.display = "none ";
                                var f = this.files,
                                    i, r = new RegExp(this.accept.replace(/,/g, '|')),
                                    b = $('#image_preview');

                                for (i = 0; i < f.length; ++i) {

                                    if (r.test(f[i].type)) b.append("<img class='thumb' src='" + URL.createObjectURL(f[i]) + "'>");
                                }
                            });
                        });
                    </script>

                </div>


                <div class="column is-autos" style="text-align: center">

                    <div class="columns">
                        <div class="column" style="text-align: left; color: blue; ">
                            <p>Статус</p><br>
                            <div class="field" style="margin: 10px 0 10px;">
                                <p>Имя</p>
                            </div>
                            <div class="field" style="margin: 25px 0;">
                                <p>Фамилия</p>
                            </div>
                            <div class="field" style="margin: 30px 0;">
                                <p>Отчество</p>
                            </div>
                            <div class="field" style="margin: 0 0 25px 0 ;">
                                <p>Место учебы</p>
                            </div>
                            <div class="field" style="margin: 25px 0;">
                                <p>Место работы</p>
                            </div>






                        </div>
                        <div class="column">
                            <p>Учащийся</p><br>

                            <div class="field">
                                <input class="input" type="text" placeholder="Имя" value="<?php echo $arr['name']; ?>">
                            </div>
                            <div class="field">
                                <input class="input" type="text" placeholder="Фамилия" value="<?php echo $arr['surname']; ?>">
                            </div>
                            <div class="field">
                                <input class="input" type="text" placeholder="Отчество" value="<?php echo $arr['patronymic']; ?>">
                            </div>
                            <div class="field">
                                <input class="input" type="text" placeholder="Место учебы" value="<?php echo $arr['study']; ?>">
                            </div>
                            <div class="field">
                                <input class="input" type="text" placeholder="Место работы" value="<?php echo $arr['work']; ?>">
                            </div>



                            <!-- php -->

                            <style>
                                input .input {
                                    padding-bottom: 100px;
                                }
                            </style>
                        </div>
                    </div>
                    </form>
                    <a href='../try_verif'><button class="button is-link is-rounded " style="">Запросить верификацию</button></a>

                </div>
            </div>
        </section>
        <section style="padding:0 10% ;text-align: center; margin-top: 2%; ">
            <div class="title" style="margin: 50px 0;">О себе</div>
            <div class="box">
                <div class="field-body" style="">
                    <div class="field">
                        <div class="control">
							<form method='post' action=''>
                            <textarea class="textarea" placeholder="Расскажите о себе" name='bio'><?php echo $arr['bio']; ?></textarea>
                            <button class="button is-link is-rounded " style="margin-top:1vh;">Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section style="padding:0 10% ;text-align: center; margin-top: 2%; ">
            <div class="title" style="margin-top: 50px ;">Мои проекты</div>
            <div class="hero is-fullheight-with-navbar">
                <div class="hero-body">
                    <div class="glider-contain" style="text-align: center;">

                        <div class="glider">
                           <?php include_once('../module/generate_glider_pub.php');?>
                        </div>
                        <button aria-label="Previous " class="glider-prev ">«</button>
                        <button aria-label="Next " class="glider-next ">»</button>


                        <div role="tablist " class="dots "></div>
                    </div>
                </div>
        </section>
        </div>

        <div class="is-fullheight-with-navbar" style=" background-image:url(niz.png); background-repeat: no-repeat; background-position: bottom right;">

            <div class="section" style="padding:0 10%;text-align: center;  ">
                <h1 class="title " style="padding-bottom: 3vw; padding-top: -3vw;">Мои курсы и стажировки </h1>
                <div class="columns ">

                    <div class=" column ">
                        <figure class="image image is-2by1 "> <img src="../public_image/default/60.jpg "></figure>
                        <br>
                        <p>Международная стажировка</p>
                        <button class="button is-link is-rounded " style="margin: 2vw; ">Подробнее</button>

                    </div>
                    <div class="column ">
                        <figure class="image image is-2by1 "><img src="../public_image/default/90.jpg "></figure><br>
                        <p>Дипломы ведущих стран мира</p>
                        <button class="button is-link is-rounded " style="margin: 2vw; ">Подробнее</button>

                    </div>
                    <div class="column ">
                        <figure class="image image is-2by1 "> <img src="../public_image/default/40.jpg "></figure><br>
                        <p>Новый коллектив и поездки</p>
                        <button class="button is-link is-rounded " style="margin: 2vw; ">Подробнее</button>

                    </div>

                </div>
            </div>
        </div>
        
        <script>
            window.addEventListener('load', function() {
                new Glider(document.querySelector('.glider'), {
                    slidesToShow: 1,
                    draggable: true,
                    dots: "#dots ",
                    arrows: {
                        prev: ".glider-prev ",
                        next: ".glider-next "
                    }
                })
            })
        </script>
<?php /*
		<form action='' method='post'>
			<table>
				<tr>
					<td>
						Имя
					</td>
					<td>
						<input type='text' id='name' name='name' required value='".$arr['name']."'>
					</td>
				</tr>
				<tr>
					<td>
						Фамилия
					</td>
					<td>
						<input type='text' id='surname' name='surname' required value='".$arr['surname']."'>
					</td>
				</tr>
				<tr>
					<td>
						Отчество
					</td>
					<td>
						<input type='text' id='patronymic' name='patronymic' value='".$arr['patronymic']."'>
					</td>
				</tr>
				<tr>
					<td>
						Место учёбы
					</td>
					<td>
						<input type='text' id='study' name='study' value='".$arr['study']."'>
					</td>
				</tr>
				<tr>
					<td>
						Место работы
					</td>
					<td>
						<input type='text' id='work' name='work' value='".$arr['work']."'>
					</td>
				</tr>
				<tr>
					<td>
						<input type='submit'>
					</td>
				</tr>
			</table>
		</form>
		<form form action='' method='post'>
				<tr>
					<td>
						Старый пароль
					</td>
					<td>
						<input type='password' id='old_password' name='old_password' required>
					</td>
				</tr>
				<tr>
					<td>
						Новый пароль
					</td>
					<td>
						<input  type='password' id='password' name='old_password' required>
					</td>
					<td>
						Повторите новый пароль
					</td>
					<td>
						<input  type='password' id='d_password' name='old_password' required>
					</td>
				</tr>
				<tr>
					<td>
						<input type='submit'>
					</td>
				</tr>
			</table>
		</form>
	";*/
?>
