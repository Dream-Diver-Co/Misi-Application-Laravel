@extends('adminlte::page')

@section('content')
    <style>
        /* Custom select styles */
        .custom-select {
            appearance: none;
            padding: 8px 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
            font-size: 14px;
            width: auto;
        }

        .filter-container {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .filter-label {
            margin-right: 8px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>

    <div class="filter-container pt-5 pl-3">
        <label for="therapist-select" class="filter-label">Filter by therapist:</label>
        <select id="therapist-select" class="custom-select">
            <option value="">All</option>
            @foreach ($therapists as $therapist)
                <option value="{{ $therapist->id }}">{{ $therapist->user()->first()->first_name }}
                    {{ $therapist->user()->first()->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div id='calendar'></div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventContent: function(info) {
                    var eventStartTime = info.event.start.toLocaleTimeString([], {
                        hour: 'numeric',
                        minute: '2-digit'
                    });
                    var eventEndTime = info.event.end.toLocaleTimeString([], {
                        hour: 'numeric',
                        minute: '2-digit'
                    });

                    var timeDiv = document.createElement('div');
                    timeDiv.classList.add('fc-time');
                    timeDiv.innerHTML = eventStartTime + ' - ' + eventEndTime;

                    var titleDiv = document.createElement('div');
                    titleDiv.classList.add('fc-title');
                    titleDiv.innerHTML = info.event.title;

                    var eventDiv = document.createElement('div');
                    eventDiv.appendChild(timeDiv);
                    eventDiv.appendChild(titleDiv);
                    eventDiv.style.color = '#ffffff';

                    return {
                        domNodes: [eventDiv]
                    };
                }
            });

            var therapistSelect = document.getElementById('therapist-select');
            var allEvents = [];

            therapistSelect.addEventListener('change', function() {
                var selectedTherapistId = therapistSelect.value;
                var eventsToShow = [];

                if (selectedTherapistId === '') {
                    eventsToShow = allEvents; // Show all events
                } else {
                    eventsToShow = allEvents.filter(function(event) {
                        return event.extendedProps.therapistId == selectedTherapistId;
                    });
                }

                calendar.removeAllEvents();
                calendar.addEventSource(eventsToShow);
                calendar.render();
            });

            fetch('/calendar-events')
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    allEvents = data; // Store the original events
                    calendar.addEventSource(allEvents);
                    calendar.render();
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    </script>
@stop
