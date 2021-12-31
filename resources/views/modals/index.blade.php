{{-- Event Modal starts here --}}
<div x-data x-cloak
     x-show="$store.modal.show"
     class="row justify-content-center modalContainer position-absolute top-0 bottom-0 end-0 start-0">
    <div class="eventModal col-6 position-absolute top-50 start-50 translate-middle">
        <div x-show="$store.modal.show"
             x-transition.scale.30.duration.200ms class="card border-success mb-3">
            <div class="card-header bg-transparent border-success">New Event
                <button @click="$store.modal.show=false;$store.modal.resetEventForm()"
                        class="btn btn-sm btn-close float-end">
                </button>
            </div>
            <div class="card-body text-success">
                <p x-text="`Event for ${$store.modal.eventDate}`"></p>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title</label>
                        <input x-model="$store.modal.eventTitle" type="text" class="form-control" name="title"
                               id="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Event Description</label>
                        <input x-model="$store.modal.eventDescription" type="text"
                               name="description"
                               class="form-control"
                               id="description">
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Event Time</label>
                        <input x-model="$store.modal.eventTime" type="time" name="event_date"
                               class="form-control"
                               id="description">
                        <p x-text="`${$store.modal.eventTime}`"></p>
                    </div>
                    <button x-show="!$store.modal.update" @click.prevent="$store.modal.submitEvent()"
                            class="btn btn-primary">
                        Submit
                    </button>

                    <button x-show="$store.modal.update" @click.prevent="$store.modal.updateEvent()"
                            class="btn btn-info"
                    > Update
                    </button>
                    <button x-show="$store.modal.update" @click.prevent="$store.modal.deleteEvent()"
                            class="btn btn-danger"
                    > Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

