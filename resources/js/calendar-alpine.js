window.opencreatemodal = (calendarObject, dateEvent) => window.dispatchEvent(new CustomEvent('opencreatemodal', {
    detail: {
        date: calendarObject,
        calendarEvent: dateEvent
    }
}))

window.calendar = () => {
    return {
        Date: new Date(),
        day: null,
        month: null,
        month_string: null,
        year: null,
        calendar: null,
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
                    date: `${this.year}-${this.month < 10 ? '0' + this.month : this.month}`
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
        },
    }

}

