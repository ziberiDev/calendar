import Alpine from 'alpinejs'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap'
import './calendar-alpine.js'

window.axios = axios
window.Alpine = Alpine
// Maybe move Alpine store in separate file and require here.
Alpine.store('modal', {
    eventId: null,
    eventTitle: "",
    eventDescription: "",
    eventTime: "",
    eventDate: '',
    show: false,
    update: false,

    submitEvent() {
        let data = new FormData()
        data.append('title', this.eventTitle)
        data.append('description', this.eventDescription)
        data.append('event_date', this.eventTime ? this.eventDate + " " + this.eventTime : '')
        axios.post('event/create', data).then(res => {

            document.querySelector('[x-data]')._x_dataStack[0].$data.get_calendar()
            this.resetEventForm()
            console.log(res)
        }).catch(err => console.log(err))
    },
    deleteEvent() {
        let data = new FormData()
        data.append('id', this.eventId)
        axios.post('event/delete', data)
            .then(res => {
                document.querySelector('[x-data]')._x_dataStack[0].$data.get_calendar()
                this.resetEventForm()
                console.log(res)
            })
            .catch(err => console.log(err))
    },
    updateEvent() {
        let data = new FormData()
        data.append('title', this.eventTitle)
        data.append('description', this.eventDescription)
        data.append('event_date', this.eventTime ? this.eventDate + " " + this.eventTime : '')
        data.append('id', this.eventId)
        axios.post('event/update', data)
            .then(res => {
                document.querySelector('[x-data]')._x_dataStack[0].$data.get_calendar()
                this.resetEventForm()
                console.log(res)
            })
            .catch(err => console.log(err))
    },
    resetEventForm() {
        this.update = false
        this.show = false
        this.eventId = null
        this.eventTitle = ""
        this.eventDescription = ""
        this.eventTime = ''
        this.eventDate = ''
    }
})


Alpine.start()




