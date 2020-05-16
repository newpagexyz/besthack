 <section class="hero is-halfheight is-info has-bg-img">
        <img src="style/header_ev_create.jpg" class="is-back">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-size-2" style="color: azure;">Создание чата</h1>
            </div>
        </div>
    </section>
    <div class="is-fullheight-with-navbar" style=" background:url(verh.png)  no-repeat; ">
        <div class="is-fullheight-with-navbar" style=" background-image:url(niz.png); background-repeat: no-repeat; background-position: bottom right;">
            <form action='' method='post' enctype='multipart/form-data'>
            <div class="hero is-small" style="padding: 0 10%;">
                <div class="hero-body">
                    <div class="slid">

                        <a>
                            <figure class="is-halfheight has-ratio " width="640" height="360" style="padding-left: 20%; padding-right: 20%">
                                <img src="../public_image/default/60.jpg">
<input name='userfile' class="file-input" type='file' required>
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
            <section class="container" style="padding: 0 10%; padding-bottom: 5%;">
                <div class="columns is-gapless is-multiline is-mobile" style="margin: 0 10%;">

                    <div class="column is-narrow">
                        <label class="label">Название чата:&nbsp;</label>
                    </div>
                    <div class="column is-auto">
                        <input class="input" name='chat_name' type='text' require placeholder="Название">
                    </div>
                </div>
                <a><button class="button is-link is-rounded " style="margin: 2vw 0 -2vw; position: relative;left: 50%;transform: translate(-50%, 0);">Создать</button></a>

            </section>
		</form>
        </div>
    </div>
