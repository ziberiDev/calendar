@extends('main.main')

@section('content')

    <div x-cloak x-data
         x-init="$store.calendar.initialize();$watch('$store.calendar.user' , () => $store.calendar.get_calendar())"
         class="container">
        <div class="row">
            <div class="col-8 mx-auto text-center my-3">
                <span class="fw-bolder fs-4" x-text="`${$store.calendar.year} ${$store.calendar.month_string} `"></span>
                <div class="d-flex justify-content-center">
                    <div @click="$store.calendar.prevYear()" class="btn">Prev Year</div>
                    <div @click="$store.calendar.nextYear()" class="btn btn-secondary">Next Year</div>
                    <div @click="$store.calendar.prevMonth()" class="btn">Prev Month</div>
                    <div @click="$store.calendar.nextMonth()" class="btn btn-secondary">Next Month</div>
                </div>
                <div class="mt-3">
                    <form class="d-flex justify-content-between align-items-center">
                        <div>
                            <label class="form-label" for="vacation_date" >Set vacation start date.</label>
                            <input x-model="$store.calendar.vacation_start_date" class="form-control" id="vacation_date" type="date"  >
                        </div>
                        <div>
                            <label for="duration" class="form-label">Set duration of vacation.</label>
                            <input x-model="$store.calendar.vacation_duration" id="duration" min="1" x-bind:max="$store.calendar.user_vacation_days" type="number"
                                   class="form-control">
                        </div>
                        <div class="align-self-end">
                            <button @click.prevent="$store.calendar.setVacation()" class="btn btn-sm btn-primary form-control">Set vacation
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap py-5">
            <template x-for="(calendarDay , index) in $store.calendar.calendar" :key="index">
                <div @mouseover="$store.calendar.calenderHoverIn($el)"
                     @mouseleave="$store.calendar.calendarHoverOut($el)"
                     class="calendarDay border border-3 overflow-auto"
                     x-bind:class="[(+index === $store.calendar.day) ? 'bg-success' : '',calendarDay.onVacation ? 'border-warning' : '']">
                    <div class="text-center pb-2"
                         @click="$store.modal.eventDate = calendarDay.date;$store.modal.show = true">
                        <span x-text="index"></span>
                        <span x-text="calendarDay.day_string"></span>
                    </div>

                    <ul x-show="calendarDay.holidays.length" class="list-unstyled">
                        <template x-for="holiday in calendarDay.holidays">
                            <li class="btn btn-sm btn-outline-danger text-start eventLi w-100" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" :title="holiday.description" x-text="holiday.name">
                            </li>
                        </template>
                    </ul>
                    <ul class="list-unstyled">
                        <template x-for="event in calendarDay.events">
                            <li class="btn btn-sm btn-outline-primary text-start mb-1 eventLi w-100" @click="
                               $store.modal.eventDate = calendarDay.date;
                               $store.modal.eventDescription = event.description;
                               $store.modal.eventTime = $store.calendar.returnDateHours(event.event_date);
                               $store.modal.eventTitle = event.title;
                               $store.modal.eventId = event.id;
                               $store.modal.event_user_id = event.user_id;
                               $store.modal.update = true;
                               $store.modal.show = true"
                                x-text="`${event.title} ${$store.calendar.returnDateHours(event.event_date)}`">
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
        @include('modals.index')
    </div>
@endsection