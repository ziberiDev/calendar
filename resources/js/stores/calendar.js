import Alpine from "alpinejs";
import axios from "axios";

Alpine.store('calendar', {
    Date: new Date(),
    day: null,
    month: null,
    month_string: null,
    year: null,
    calendar: null,
    user: null,
    user_vacation_days: 0,
    vacation_start_date: '',
    vacation_duration: '',
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
    get_calendar: function () {
        axios.get('authUser/calendar', {
            params: {
                date: `${this.year}-${this.month < 10 ? '0' + this.month : this.month}`,
                id: this.user ? `${this.user.id}` : this.user
            }
        }).then(data => {
            this.calendar = data.data.calendar
            this.month_string = data.data.month
            this.user_vacation_days = data.data.user_vacation_days
            console.log(data)
        }).catch(err => console.log(err))
    },
    setVacation() {
        let data = new FormData()
        data.append('start_date', this.vacation_start_date)
        data.append('duration', this.vacation_duration)
        axios.post('vacation/create', data).then(res => {
            this.get_calendar()
        }).catch(err => console.log(err.response))
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