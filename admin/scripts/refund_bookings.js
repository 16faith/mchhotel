function get_bookings(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/refund_bookings_crud.php",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('table-data').innerHTML = this.responseText;
    }

    xhr.send('get_bookings');
}
function refund_booking(id) {
    
    if (confirm("Are you sure you want to refund this booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('refund_booking', '');

        fetch('ajax/booking_records_crud.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
            if (data.trim() === '1') {
                alert('success', 'Booking refunded successfully!');
                get_bookings();
            } else {
                alert('danger', 'Refund failed.');
            }
        });
    }
}

function search_room(value) {
    // Example: send AJAX to search for rooms and update the table
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/refund_bookings_crud.php", true);

    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
    }

    let data = new FormData();
    data.append('search_rooms', '');
    data.append('name', value);

    xhr.send(data);
}

window.onload = function(){
    get_bookings();
}