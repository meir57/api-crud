import User from './User.js';
import Todo from './todo.js';

let auth = document.forms['auth'];

auth.login.onclick = (credentials) => (new User(credentials)).login();

export default class Auth {
    static init(){
        if (localStorage.getItem('authorization')) {
            Todo.init();
            document.querySelector('.logout').style.display = 'block';
        } else {
            auth.style.display = 'block';
            document.querySelector('.logout').style.display = 'none';
        }
    }
}


Auth.init();