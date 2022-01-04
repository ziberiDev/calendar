import Alpine from "alpinejs";
import axios from "axios";

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