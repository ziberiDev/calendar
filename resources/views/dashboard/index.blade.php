@extends('main.main')

@section('content')
    <div x-cloak x-data="calendar()" x-init="initialize()" class="container">
        <div class="row">
            <div class="col-4 mx-auto text-center my-3">
                <span class="fw-bolder fs-4" x-text="`${year} ${month_string} ` "></span>
                <div class="d-flex">
                    <div @click="prevYear()" class="btn">Prev Year</div>
                    <div @click="nextYear()" class="btn btn-secondary">Next Year</div>
                    <div @click="prevMonth()" class="btn">Prev Month</div>
                    <div @click="nextMonth()" class="btn btn-secondary">Next Month</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap py-5">
            <template x-for="(calendarDay , index) in calendar">
                <div @click="$dispatch('openmodal' , calendarDay)" @mouseover="calenderHoverIn($el)"
                     @mouseleave="calendarHoverOut($el)"
                     class="calendarDay border border-3 overflow-hidden"
                     x-bind:class="(+index === day) ? 'bg-primary' : ''">
                    <span x-text="index"></span>
                    <span x-text="calendarDay.day_string"></span>
                    <ul>
                        <template x-for="(event , key) in calendarDay.events" :key="key">
                            <li class="eventLi">
                                <small x-text="`${event.title} ${returnDateHours(event.event_date)}`"></small>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
        {{-- Event Modal starts here --}}
        <div @openmodal.window=" modal=true ; eventDate=$event.detail.date"
             x-show="modal"
             class="row justify-content-center modalContainer position-absolute top-0 bottom-0 end-0 start-0">
            <div class="eventModal col-6 position-absolute top-50 start-50 translate-middle">
                <div x-show="modal"
                     x-transition.scale.30.duration.200ms class="card border-success mb-3">
                    <div class="card-header bg-transparent border-success">New Event
                        <button @click="modal=false" class="btn btn-sm btn-danger float-end">x</button>
                    </div>
                    <div class="card-body text-success">
                        <p x-text="`Event for ${eventDate}`"></p>
                        <form action="#" method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Title</label>
                                <input x-model="eventTitle" type="text" class="form-control" name="title" id="title">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Event Description</label>
                                <input x-model="eventDescription" type="text" name="description" class="form-control"
                                       id="description">
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Event Time</label>
                                <input x-model="eventTime" type="time" name="event_date"
                                       class="form-control"
                                       id="description">
                                <p x-text="`${eventTime}`"></p>
                            </div>
                            <button @click.prevent="submitEvent()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection