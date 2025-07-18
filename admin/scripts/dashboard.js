function booking_analytics(period=1){

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/dashboard_crud.php",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('total_bookings').textContent = data.total_bookings;
        document.getElementById('total_amount').textContent = '$'+data.total_amount;

        document.getElementById('active_bookings').textContent = data.active_bookings;
        document.getElementById('active_amount').textContent = '$'+data.active_amount;

        document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
        document.getElementById('cancelled_amount').textContent = '$'+data.cancelled_amount;
    }

   
    xhr.send('booking_analytics&period='+period);
}

function user_analytics(period=1){

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/dashboard_crud.php",true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('total_new_reg').textContent = data.total_new_reg;

        document.getElementById('total_queries').textContent = data.total_queries;
    }

   
    xhr.send('user_analytics&period='+period);
}

window.onload = function(){
    booking_analytics();
    user_analytics();
}