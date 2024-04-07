import Task from './Task.js';
import TaskList from './TaskList.js';
import User from './User.js';

export default class Todo {
    static async init() {
        let tasks = document.forms['tasks'];
        let list  = document.forms['list']; 
        
        tasks.style.display = 'block';
        list.style.display = 'block';
        await TaskList.render(list);
        tasks.add.onclick = (task) => TaskList.create(new Task(task));
        document.querySelector('.logout').addEventListener('click', User.logout);
        document.querySelector('.logout').style.display = 'block';
    }
}