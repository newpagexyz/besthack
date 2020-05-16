
<?php 
$level=1;
$title="Чат";
include_once('../module/header.php');?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {

                        // Get the target from the "data-target" attribute
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);

                        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');

                    });
                });
            }

        });
    </script>
        <section class="hero is-info" style="margin-top: -2%;">
            <div class="hero-body">
                <div class="container is-size-5">
                    <p class="title " style="text-align: center; margin: 50px 0 0;  ">Мои сообщения</p>
                </div>
            </div>
        </section>
        <div class="is-fullheight-with-navbar" style=" background:url(verh.png)  no-repeat; padding: 2%;  ">
            <div class="is-fullheight-with-navbar" style=" background-image:url(niz.png); background-repeat: no-repeat; background-position: bottom right;">
                <div class="container" style="padding: 0 10%;">

                    <div class="columns box">
                        <div class="column is-narrow " id="display-chats">
                            <a>k</a>
                        </div>
                        <div class="column  is-auto">
                            <div class="sl" id="message-slider" style="width: 100%; height: 400px; overflow-y: scroll; overflow-x: hidden;">
                            </div>
                        </div>
                        <style>
                            .sl {
                                border-left: 2px solid #ccc;
                                /* Параметры линии */
                                margin-left: 20px;
                                /* Отступ слева */
                                padding-left: 10px;
                                /* Расстояние от линии до текста */
                                border-left: 2px solid #ccc;
                                /* Параметры линии */
                                margin-left: 20px;
                                /* Отступ слева */
                                padding-left: 10px;
                            }
                        </style>
                    </div>
                    <div style="margin-left: 10%; margin-right: 10%" class="columns">
                        <div class="control column is-auto">
                            <input type="text" class="input" id="textarea"></div>
                        <div class="control column is-narrow">
                            <input type="button" class="input is-rounded" id='submit' value="отправить" style="background-color: left;"></div>
                    </div>

                    <div class="glider-contain">
                        <div class="columns" id='glider' style="margin-left: 30%; margin-right: 30%">
                        </div>
                        <button aria-label="Previous" class="glider-prev">«</button>
                        <button aria-label="Next" class="glider-next">»</button>
                        <div role="tablist" class="dots"></div>
                    </div>


                    <script src="chat.js"></script>
                </div>
            </div>
        </div>
    </body>

</html>
