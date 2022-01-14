import Alpine from 'alpinejs'
import axios from 'axios'

const Swal = require('sweetalert2')

window.axios = axios
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap'
import './stores/calendar.js'
import './stores/modal.js'
import './nav.js'
import './createUser.js'
import {getElement, getjQuery} from "bootstrap/js/src/util";

console.log(getElement('.container').classList)

axios.interceptors.response.use((response) => {
    console.log(response.status)
    if (response.status === 401) {
        alert("You are not authorized");
    }
    return response;
}, (error) => {

    if (error.response && error.response.data) {
        if (error.response.status === 403) {
            Swal.fire({
                icon: 'error',
                title: error.response.data,
                showConfirmButton: false,
                timer: 1500
            })
        }
        return Promise.reject(error.response.data);
    }
    return Promise.reject(error.message);
});
Alpine.start()





