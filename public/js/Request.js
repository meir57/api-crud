export default class Request {
    static async post(route, data) {
        return fetch(route, {
            method: 'post',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authorization'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(response => response.json());
    }

    static async get(route) {
        return fetch(route, {
            method: 'get',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authorization'),
                'Content-Type': 'application/json',
            },
        }).then(response => response.json());
    }

    static async delete(route) {
        return fetch(route, {
            method: 'delete',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authorization'),
                'Content-Type': 'application/json',
            },
        }).then(response => response.json());
    }

    static async put(route, data) {
        return fetch(route, {
            method: 'put',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authorization'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(response => response.json());
    }
}