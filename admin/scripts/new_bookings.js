function get_bookings(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('table-data').innerHTML = this.responseText;
    }

    xhr.send('get_bookings');
}

function cancel_booking(id){
    if(confirm("Are you sure you want to cancel this booking?")){
        let data = new FormData();
        data.append('booking_id', id);
        data.append('status', 'cancelled');
        data.append('cancel_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings_crud.php", true);

        xhr.onload = function(){
            if(this.responseText.trim() == '1'){
                alert('Booking cancelled!');
                get_bookings();
            } else {
                alert('Failed to cancel booking!');
            }
        }

        xhr.send(data);
    }
}

function search_room(value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings_crud.php", true);

    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
    }

    let data = new FormData();
    data.append('search_rooms', '');
    data.append('name', value);

    xhr.send(data);
}

document.getElementById('assign-room').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const bookingId = button.getAttribute('data-booking-id');
    document.getElementById('assign_booking_id').value = bookingId;

    const container = document.getElementById('room-selection-container');
    container.innerHTML = '<div class="text-muted">Loading rooms...</div>';

    fetch('ajax/fetch_rooms.php')
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';

            const statusClass = {
                available: 'btn-outline-success',
                occupied: 'btn-outline-warning',
                unavailable: 'btn-outline-danger'
            };

            data.forEach(group => {
                const typeHeading = document.createElement('div');
                typeHeading.innerHTML = `<strong>${group.room_type}</strong>`;
                container.appendChild(typeHeading);

                const scrollRow = document.createElement('div');
                scrollRow.classList.add('scroll-row', 'mb-3');

                group.rooms.forEach(room => {
                    const status = room.status.toLowerCase();
                    const className = statusClass[status] || 'btn-outline-secondary';
                    const isDisabled = status !== 'available';

                    const btn = document.createElement('button');
                    btn.className = `btn ${className} btn-sm shadow-none assign-room-btn`;
                    btn.textContent = room.room_number;
                    btn.dataset.room = room.room_number;    

                    if (isDisabled) {
                        btn.disabled = true;
                        btn.setAttribute('aria-disabled', 'true');
                    }

                    btn.onclick = function () {
                        if (btn.disabled) return;
                        document.querySelectorAll('.assign-room-btn').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                    };

                    scrollRow.appendChild(btn);
                });

                container.appendChild(scrollRow);
            });

            if (data.length === 0) {
                container.innerHTML = '<div class="text-danger">No rooms found.</div>';
            }
        })
        .catch(err => {
            container.innerHTML = '<div class="text-danger">Failed to load rooms.</div>';
            console.error(err);
        });
});


document.getElementById('assign_room_form').addEventListener('submit', function (e) {
    e.preventDefault();

    const bookingId = document.getElementById('assign_booking_id').value;
    const roomNoBtn = document.querySelector('.assign-room-btn.active');
    const roomNo = roomNoBtn?.dataset.room;

    if (!roomNo) {
        alert('warning', 'Please select a room!');
        return;
    }

    const confirmAssign = confirm(`Are you sure you want to assign Room ${roomNo} to this booking?`);
    if (!confirmAssign) return;

    fetch('ajax/assign_room.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `room_no=${roomNo}&booking_id=${bookingId}`
    })
    .then(res => res.text())
    .then(data => {
        console.log("Server response:", data);
        data = data.trim();

        if (data === 'success') {
            alert('success', 'Room assigned successfully!');
            get_bookings();
            bootstrap.Modal.getInstance(document.getElementById('assign-room')).hide();
        } else if (data === 'not_available') {
            alert('warning', 'This room is no longer available.');
        } else if (data === 'update_failed') {
            alert('danger', 'Failed to assign room. Please try again.');
        } else if (data === 'invalid_data') {
            alert('danger', 'Invalid data provided.');
        } else {
            alert('warning', 'Unexpected response: ' + data);
        }
    })
    .catch(err => {
        console.error("AJAX error:", err);
        alert('danger', 'Request failed: ' + err.message);
    });
});


window.onload = function(){
    get_bookings();
}