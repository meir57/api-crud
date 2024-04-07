import Request from "./Request.js";
import TaskList from "./TaskList.js";
import Todo from "./todo.js";

export default class User {
    constructor(credentials) {
        if (credentials) {
            this.email = this.get(credentials, 'email');
            this.password = this.get(credentials, 'password');
            this.form = credentials.target.form;
        }
    }

    get(task, prop) {
        return task.target.form.elements[prop].value;
    }

    object() {
        return {
            email:    this.email,
            password: this.password
        }
    }

    async login() {
        let response = await Request.post('/api/login/', this.object());
        localStorage.setItem('authorization', response.data.token);
        this.form.style.display = 'none';
        Todo.init();
    }

    static async logout() {
        await Request.post('/api/logout');
        TaskList.clear(document.forms['tasks']);
        document.forms['tasks'].style.display = 'none';
        document.forms['list'].style.display = 'none';
        document.forms['auth'].style.display = 'block';
        document.querySelector('.logout').style.display = 'none';
        //location.reload();
    }
}