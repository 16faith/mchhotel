function get_bookings(page=1){
    currentPage = page;
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/booking_records_crud.php",true);

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = data.table_data;
        document.getElementById('pagination').innerHTML = data.pagination;
    }

    let params = new URLSearchParams();
    params.append('get_bookings', '');
    params.append('page', page);

    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params.toString());
}
function change_page(page){
    get_bookings(page);
}

function checkout_booking(id){
    if(confirm("Are you sure you want to checkout this guest?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('checkout_booking', '');

        fetch('ajax/booking_records_crud.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
            if (data.trim() === '1') {
                alert('success', 'Guest successfully checked out. Room is now available.');
                get_bookings();
            } else {
                alert('danger', 'Failed to checkout guest.');
            }
        });
    }
}

function cancel_booking(id){
    if(confirm("Are you sure, you want to cancel this booking?")){
        let data = new FormData();
        data.append('booking_id',id);
        data.append('status', 'cancelled');
        data.append('cancel_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/booking_records_crud.php",true);

        xhr.onload = function(){
            if(this.responseText.trim() == '1'){
                alert('success', 'Booking  cancelled!');
                get_bookings();
            }
            else{
                alert('danger','Failed to cancel booking!');
            }
        }
        xhr.send(data);
    }
}

function search_room(value){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/booking_records_crud.php",true);

    xhr.onload = function(){
        let response = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = response.table_data;
        document.getElementById('pagination').innerHTML = response.pagination;
    }

    let data = new FormData();
    data.append('search_rooms', '');
    data.append('name', value);
    data.append('page', currentPage);

    xhr.send(data);
}

window.onload = function(){
    get_bookings();
}