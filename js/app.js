/**
 * Ajax message retrieval function
 */
function getMessages(){
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("GET", "Tchat.php");
    requeteAjax.onload = function (){
        //Retrieving all the information encoded in JSON in the Tchat.php page in the getMessages function
        const resultat = JSON.parse(requeteAjax.responseText);
        //We reverse the data and transform the information in the JSON array
        const html = resultat.reverse().map(function(message){
            return `
                <div class="message">
                    <span class="date">${message.date_publish.substring(11, 16)}</span>
                    <span class="author">${message.pseudo}</span> :
                    <span class="content">${message.message}</span>
                    <hr>
                </div>
            `;
        //We join all the information to have a single large character string
        }).join('');

        const messages = document.querySelector('#message');
        messages.innerHTML = html;

        //We set the position of the scrollbar to the position of the last message
        messages.scrollTop = messages.scrollHeight;
    };

    requeteAjax.send();
}

/**
 * Function to send a message
 * @param event Form event
 */
function postMessage(event){
    event.preventDefault();

    const message = document.querySelector('#messageTxt');
    const user_fk = document.querySelector('#user_fk');

    const data = new FormData();
    data.append('user_fk', user_fk.value);
    data.append('message', message.value);

    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open('POST', 'Tchat.php?task=write');
    requeteAjax.onload = function(){
        message.value = '';
        message.focus();
        getMessages();
    }

    requeteAjax.send(data);
}

/**
 * Function to display a message when a user logs in
 * @param event Form event
 */
function connexion(event){
    event.preventDefault();

    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open('POST', 'Tchat.php?task=connexion');
    requeteAjax.onload = function(){
        getMessages();
    }

    requeteAjax.send();
}

/**
 * Function to display a message when a user disconnects
 * @param event Form event
 */
function deconnexion(event){
    event.preventDefault();

    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open('POST', 'Tchat.php?task=deconnexion');
    requeteAjax.onload = function(){
        getMessages();
    }

    requeteAjax.send();
}

document.querySelector('form').addEventListener('submit', postMessage);
const interval = window.setInterval(getMessages, 3000);
getMessages();