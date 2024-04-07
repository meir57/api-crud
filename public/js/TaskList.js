import Task from './Task.js';
import Request from './Request.js';
import User from './User.js';

export default class TaskList {
    static create(task) {
        let data = task.object();
        Request.post('/api/tasks/', data)
        .then(response => {
            if (response.success) {
                this.render();
            } else {
                this.handle(response)
            }
        });

        this.clear(task.form);
    }

    static remove(task) {
        task = task.srcElement.parentNode;
        Request.delete('/api/tasks/' + task.id)
        .then(response => {
            if (response.success) {
                task.remove();
            } else {
                this.handle(response)
            }
        });
    }

    static toggle(item) {
        let task    = item.srcElement.parentNode;
        let status  = Task.status(task.children.toggle.checked);

        let data = {status: status}
        Request.put('/api/tasks/' + task.id, data)
        .then(response => {
            if (!response.success) {
                this.handle(response)
            }
        });

        this.outline(task, status);
    }

    static async all() {
        return await Request.get('/api/tasks/')
        .then(response => this.handle(response));
    }

    static async get(id) {
        return await Request.get('/api/tasks/' + id);
    }

    static async handle(response) {
        if (response.success) {
            if (!this.items) {
                return;
            }

            let tasks = response.data;

            this.items.innerHTML = '';

            for (let task of tasks) {
                this.items.insertAdjacentElement('beforeend', this.outline(this.item(task), task.status));
            }
        } else {
            if (response.status == 401) {
                localStorage.removeItem('authorization');
                User.logout();
            } else {
                this.error(response.errors)
            }
        }
    }

    static async render(items = null) {
        if (items) {
            this.items = items;
        }
        await this.all();
    }

    static item(task) {
        let task_card = document.createElement('div');
        task_card.id = task.id;
        task_card.classList.add('task', task.status);

        let title = document.createElement('b');
        title.innerText = task.name;
        title.className = 'title';

        let input = document.createElement('input');
        input.type = 'checkbox';
        input.name = 'toggle';
        input.checked = task.status == 'finished';
        input.onclick = (self) => this.toggle(self);

        let remove = document.createElement('button');
        remove.type = 'button';
        remove.name = 'delete';
        remove.innerText = '×';
        remove.onclick = (self) => this.remove(self);

        let description = document.createElement('blockquote');
        description.innerText = task.description;

        task_card.append(input, remove, title, description);

        return task_card;
    }

    static error(message) {
        let tasks = document.forms['tasks'];
        let fields = Object.keys(message);

        for (let field of fields) {
            let error = tasks[field].parentNode.querySelector('.error');
            error.innerHTML = message[field];
            error.style.display = 'block';
            error.onclick = () => error.style.display = 'none';
        }
    }

    static outline(task, state) {
        if (typeof task == 'string') {
            task = this.element(task);
        }

        if (state == 'finished') {
            task.classList.add(state);
            task.classList.remove('unfinished');
        } else {
            task.classList.add(state);
            task.classList.remove('finished');
        }

        return task;
    }

    static element(html) {
        let div = document.createElement('div');
        div.innerHTML = html.trim();
        return div.firstChild;
    }

    static clear(form) {
        form.reset();
        form.querySelectorAll('.error').forEach((error) => error.style.display = 'none');
    }
}