export default class Task {
    constructor(task) {
        this.name = this.get(task, 'name');
        this.description = this.get(task, 'description');
        this.form = task.target.form;
    }

    get(task, prop) {
        return task.target.form.elements[prop].value;
    }

    object() {
        return {
            name: this.name,
            description: this.description,
        };
    }

    static status(done = false) {
        return done ? 'finished' : 'unfinished';
    }
}