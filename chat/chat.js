const mainContainer = document.getElementById('message-slider');

let currentChatId = -1;

let latestTimestamp = Date.parse('March 7, 2014');

let messages = [];

let needToClean = false;

//Функция дял ajax-get запросов, вводится адрес и функция для возврата(необязательно);
function ajax(url, fun = false) {
    var xmlhttp = new XMLHttpRequest();
    var func = fun;
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                if (func != undefined & func != false) {
                    func(xmlhttp.responseText);
                } else {
                    console.log(xmlhttp.responseText);
                }
            } else {
                if (func != undefined & func != false) {
                    func(xmlhttp.status + ': ' + xmlhttp.statusText);
                } else {
                    console.log(xmlhttp.status + ': ' + xmlhttp.statusText);
                }
            }
        }
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

//Функция запроса чатов пользователя (авторизация через cookie)
function get_chats(fun) {
    ajax("https://besthack.newpage.xyz/ajax_api/get_chats.php", fun);
}

function get_users(c, fun) {
    ajax("https://besthack.newpage.xyz/ajax_api/get_users.php?chat=" + c, fun);
}

function push_message(c, text, fun) {
    ajax("https://besthack.newpage.xyz/ajax_api/push_message.php?chat=" + c + "&data=" + text, fun);
}

function get_messages(c, fun, last = false) {
    if (last) {
        ajax("https://besthack.newpage.xyz/ajax_api/get_messages.php?chat=" + c + "&last=" + last, fun);
    } else {
        ajax("https://besthack.newpage.xyz/ajax_api/get_messages.php?chat=" + c, fun);
    }
}

function new_invite_link(c, fun) {
    ajax("https://besthack.newpage.xyz/ajax_api/new_invite_link.php?chat=" + c, fun);
}

function drop_user(c, uid, fun) {
    ajax("https://besthack.newpage.xyz/ajax_api/drop_user.php?chat=" + c + "&uid=" + uid, fun);
}

function user_info_quick(uid, fun) {
    ajax("https://besthack.newpage.xyz/ajax_api/user_info_quick.php?uid=" + uid, fun);
}


class Message {
    constructor(owner, text, timestamp, id) {
        this.owner = owner;
        this.text = text;
        this.timestamp = timestamp;
        this.id = id;
    }
}

class User {
    constructor(id, name, surname, avatar) {
        this.id = id;
        this.name = name;
        this.surname = surname;
        this.avatar = avatar;
    }
}

let users = [];

let gliders = [];

function wasGliderAdded(user) {
    for (let i = 0; i < gliders.length; i++)
        if (user.id === gliders[i]) {
            return true;
        }
    return false;
}


function appendToSlider(user) {
    if (wasGliderAdded(user)) return;
    gliders.push(user.id);
    const pers = document.createElement('div');
    pers.className = 'column';
    const persfig = document.createElement('figure');
    persfig.className = 'image is-64x64';
    const image = document.createElement('img');
    image.src = user.avatar;
    image.className = 'is-rounded';
    persfig.append(image);
    pers.append(persfig);
    document.getElementById('glider').append(pers);
}

function minSeenedId() {
    ans = 1000000000;
    for (let i = 0; i < messages.length; i++) {
        if (messages[i].id < ans) ans = messages[i].id;
    }
    return ans;
}


class RecyclerView {

    createNewDivs(maxMessages) {
        for (let i = 0; i < maxMessages; i++) {
            const div = document.createElement('div');
            div.className = 'columns';

            const firstColumn = document.createElement('div');
            firstColumn.className = 'column is-one-fifth';
            const figure = document.createElement('figure');
            figure.className = 'image is-64x64'
            const avatar = document.createElement('img');
            figure.append(avatar);
            avatar.className = 'is-rounded';
            firstColumn.append(figure);

            const secondColumn = document.createElement('div');
            secondColumn.className = 'column';
            const username = document.createElement('p');
            secondColumn.append(username);

            const thirdColumn = document.createElement('div');
            thirdColumn.className = 'column';
            const text = document.createElement('p');
            thirdColumn.append(text);

            this.divs.push(div);
            this.avatars.push(avatar);
            this.texts.push(text);
            this.usernames.push(username);

            div.append(firstColumn);
            div.append(secondColumn);
            div.append(thirdColumn);

            this.container.prepend(div);
        }
    }

    constructor(container, maxMessages) {
        this.container = container;
        this.maxMessages = maxMessages;
        this.pos = 0;

        this.divs = [];
        this.usernames = [];
        this.avatars = [];
        this.texts = [];

        this.createNewDivs(maxMessages);
    }


    render() {
        for (let i = this.pos; i < this.pos + Math.min(this.maxMessages - 1, messages.length); i++) {
            const ownerId = messages[i].owner;
            let owner = {};
            let index = 0;
            for (let j = 0; j < users.length; j++) {
                if (users[j].id === ownerId) {
                    owner = users[j];
                    index = j;
                    break;
                }
            }
            if (!(owner.name)) {
                user_info_quick(ownerId, (userdata) => {
                    userdata = JSON.parse(userdata);
                    const user = new User(ownerId, userdata.name, userdata.surname, userdata.image);
                    users[index] = user;
                    this.avatars[i].src = userdata['image'];
                    this.texts[i].innerText = messages[i].text;
                    this.usernames[i].innerText = userdata.name + messages[i].timestamp;
                    //appendToSlider(user)
                });
            } else {
                this.avatars[i].src = owner.avatar;
                this.texts[i].innerText = messages[i].text;
                this.usernames[i].innerText = owner.name + messages[i].timestamp;
            }
        }
    }


    init() {
        this.container.addEventListener('click', () => {
            //const currentScroll = this.container.scrollTop;
            //if (currentScroll < 10) {
            this.pos += this.maxMessages;
            loadMoreMessages(minSeenedId());
            return;
            //}
        });
    }
}


let myRecyclerView = new RecyclerView(mainContainer, 10);
myRecyclerView.init();

function loadUsers() {
    users = [];
    get_users(currentChatId, (res) => {
        res = JSON.parse(res);
        for (let i = 0; i < res.length; i++) {
            users.push(new User(res[i], null, null, null));
        }
        loadMessages();
    });
}


function clean() {
    myRecyclerView.divs.forEach(div => {
        div.remove();
    });
    messages = [];
    myRecyclerView = new RecyclerView(mainContainer, 10);
    myRecyclerView.init();

    document.getElementById('glider').innerHTML = '';
}

function loadDialogs() {
    get_chats((res) => {
        const display_chats = document.getElementById('display-chats');
        res = JSON.parse(res);
        res.forEach(chat => {
            const div = document.createElement('div');
            const link = document.createElement('a');
            link.text = chat;
            div.append(link);
            display_chats.append(div);
            link.addEventListener('click', () => {
                if (needToClean) clean();

                currentChatId = link.text;
                loadUsers();
                makeGlider();
                needToClean = true;

            })
        })
    });
}



function notInMessages(message) {
    for (let i = 0; i < messages.length; i++) {
        if (messages[i].id === message.id) {
            return false;
        }
    }
    return true;
}

function loadMoreMessages(pos) {
    get_messages(currentChatId, (res) => {
        res = JSON.parse(res);
        let newmsg = [];
        res.forEach(msg => {
            const message = new Message(msg[1], msg[3], msg[2], msg[0]);
            if (notInMessages(message)) {
                newmsg.push(message);
                //messages.push(message)
            }

        });
        newmsg.reverse();
        messages = messages.concat(newmsg);
        myRecyclerView.createNewDivs(myRecyclerView.maxMessages);
        myRecyclerView.render(messages);
        myRecyclerView.divs[myRecyclerView.divs.length - 1].scrollIntoView(true);
    }, pos);
}

function loadMessages(render = true) {
    get_messages(currentChatId, (res) => {
        res = JSON.parse(res);
        res.forEach(msg => {
            const message = new Message(msg[1], msg[3], msg[2], msg[0]);
            if (notInMessages(message))
                messages.unshift(message);
        });
        if (render) {
            myRecyclerView.render();
        } else {
            messages.forEach(msg => {
                const date = Date.parse(msg.timestamp.replace(' ', 'T'));
                if (date >= latestTimestamp) {
                    myRecyclerView.render();
                    latestTimestamp = date;
                }
            })
        }
    });
}

function reloadMessages() {
    loadMessages(true);
}


function initUi() {
    const submitButton = document.getElementById('submit');
    submitButton.addEventListener('click', () => {
        const textarea = document.getElementById('textarea');
        push_message(currentChatId, textarea.value, () => {
            reloadMessages();
            textarea.value = '';
        });
    })
}


loadDialogs();
initUi();

function makeGlider() {
    get_users(currentChatId, (res) => {
        res = JSON.parse(res);
        res.forEach(id => {
            user_info_quick(id, (res2) => {
                res2 = JSON.parse(res2);
                const user = new User(id, res2.name, res2.surname, res2.image);
                appendToSlider(user);
            })
        })
    });
}

let timer = setInterval(() => {
    loadMessages(false);
}, 1000);

