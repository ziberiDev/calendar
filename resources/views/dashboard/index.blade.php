@extends('main.main')

@section('content')

    <div x-cloak x-data
         x-init="$store.calendar.initialize();$watch('$store.calendar.user' , () => $store.calendar.get_calendar())"
         class="container">
        <div class="row">
            <div class="col-4 mx-auto text-center my-3">
                <span class="fw-bolder fs-4" x-text="`${$store.calendar.year} ${$store.calendar.month_string} `"></span>
                <div class="d-flex">
                    <div @click="$store.calendar.prevYear()" class="btn">Prev Year</div>
                    <div @click="$store.calendar.nextYear()" class="btn btn-secondary">Next Year</div>
                    <div @click="$store.calendar.prevMonth()" class="btn">Prev Month</div>
                    <div @click="$store.calendar.nextMonth()" class="btn btn-secondary">Next Month</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap py-5">
            <template x-for="(calendarDay , index) in $store.calendar.calendar" :key="index">
                <div @click=" $store.modal.eventDate = calendarDay.date;$store.modal.show = true"
                     @mouseover="$store.calendar.calenderHoverIn($el)"
                     @mouseleave="$store.calendar.calendarHoverOut($el)"
                     class="calendarDay border border-3 overflow-hidden"
                     x-bind:class="(+index === $store.calendar.day) ? 'bg-primary' : ''">
                    <span x-text="index"></span>
                    <span x-text="calendarDay.day_string"></span>
                    <ul>
                        <template x-for="(event , key) in calendarDay.events" :key="key">
                            <li class="eventLi">
                                <small @click="
                               $store.modal.eventDate = calendarDay.date;
                               $store.modal.eventDescription = event.description;
                               $store.modal.eventTime = $store.calendar.returnDateHours(event.event_date);
                               $store.modal.eventTitle = event.title;
                               $store.modal.eventId = event.id;
                               $store.modal.event_user_id = event.user_id;
                               $store.modal.update = true;"
                                       x-text="`${event.title} ${$store.calendar.returnDateHours(event.event_date)}`"></small>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
        @include('modals.index')
    </div>
@endsection