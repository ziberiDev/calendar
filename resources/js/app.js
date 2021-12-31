import Alpine from 'alpinejs'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap'
import './calendar-alpine.js'
import './nav.js'

window.axios = axios
window.Alpine = Alpine
// Maybe move Alpine store in separate file and require here.
Alpine.store('modal', {
    eventId: null,
    eventTitle: "",
    eventDescription: "",
    eventTime: "",
    eventDate: '',
    event_user_id: '',
    show: false,
    update: false,
    submitEvent() {
        let data = new FormData()
        data.append('title', this.eventTitle)
        data.append('description', this.eventDescription)
        data.append('event_date', this.eventTime ? this.eventDate + " " + this.eventTime : '')
        data.append('user_id', Alpine.store('calendar').user ? Alpine.store('calendar').user.id : Alpine.store('calendar').user)
        axios.post('event/create', data).then(res => {
            Alpine.store('calendar').get_calendar()
            this.resetEventForm()
            console.log(res)
        }).catch(err => console.log(err.response.data))
    },
    deleteEvent() {

        let data = new FormData()
        data.append('id', this.eventId)
        data.append('event_user_id', this.event_user_id)
        axios.post('event/delete', data)
            .then(res => {
                Alpine.store('calendar').get_calendar()
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
        data.append('event_user_id', this.event_user_id)
        axios.post('event/update', data)
            .then(res => {
                Alpine.store('calendar').get_calendar()
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
// Maybe move Alpine store in separate file and require here.

Alpine.store('calendar', {
    Date: new Date(),
    day: null,
    month: null,
    month_string: null,
    year: null,
    calendar: null,
    user: null,

    //  ---METHODS---
    initialize() {
        this.day = this.Date.getDate()
        this.month = this.Date.getMonth() < 12 ? this.Date.getMonth() + 1 : 1
        this.year = this.Date.getFullYear()
        this.get_calendar()
    },
    calenderHoverIn($el) {
        $el.classList.add('shadow')
    },
    calendarHoverOut($el) {
        $el.classList.remove('shadow')
    },
    get_calendar() {
        axios.get('authUser/calendar', {
            params: {
                date: `${this.year}-${this.month < 10 ? '0' + this.month : this.month}`,
                id: this.user ? `${this.user.id}` : this.user
            }
        }).then(data => {
            this.calendar = data.data.calendar
            this.month_string = data.data.month
            console.log(data)
        }).catch(err => console.log(err))
    },

    nextYear() {
        ++this.year
        this.day = 0
        this.setCurrentDay()
        this.get_calendar()
    },
    prevYear() {
        --this.year
        this.day = 0
        this.setCurrentDay()
        this.get_calendar()
    }
    ,
    nextMonth() {
        ++this.month
        this.day = 0
        if (this.month > 12) {
            ++this.year
            this.month = 1
        }
        this.setCurrentDay()
        this.get_calendar()
    },
    prevMonth() {
        --this.month
        this.day = 0
        if (this.month < 1) {
            --this.year
            this.month = 12
        }
        this.setCurrentDay()
        this.get_calendar()
    },
    setCurrentDay() {
        if ((this.Date.getMonth() + 1) === this.month && this.Date.getFullYear() === this.year) {
            this.day = this.Date.getDate()
        }
    },
    returnDateHours(date) {
        return date.split(" ")[1]
    }
})
Alpine.start()




