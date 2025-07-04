

        let carousel_s_form = document.getElementById('carousel_s_form');
        let carousel_picture_inp = document.getElementById('carousel_picture_inp');

        carousel_s_form.addEventListener('submit',function(e){
            e.preventDefault(); // prevent form submission
            add_image();
        })

        function add_image()
        {
            let data = new FormData();
            data.append('picture', carousel_picture_inp.files[0]);
            data.append('add_image', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/carousel_crud.php",true);

            xhr.onload = function(){
                var myModal = document.getElementById('carousel-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if(this.responseText == 'inv_img'){
                    alert('danger','only jpg and png images are allowed');
                    get_general();
                }
                else if(this.responseText == 'inv_size'){
                    alert('danger','images should be less than 2mb!');
                }
                else if(this.responseText == 'upd_failed'){
                    alert('danger','images upload failed. server down!');
                }
                else{
                    alert('success', 'new image added!');
                     carousel_picture_inp.value='';
                     get_carousel();
                }

            }

            xhr.send(data);
            
        }

        function get_carousel()
        {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/carousel_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('carousel-data').innerHTML = this.responseText;
            }

            xhr.send('get_carousel');
        }

        function del_image(val)
        {
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/carousel_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success','image deleted!');
                    get_carousel();
                }
                else{
                    alert('danger','operation failed!');
                }
            }

            xhr.send('del_image='+val);        
            

        }
        
        window.onload = function(){
            get_carousel();
        }