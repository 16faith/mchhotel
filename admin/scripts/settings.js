// Description: This script handles the settings management for the admin panel, including general settings, contacts, and team members.
        let general_data, contacts_data;

        let general_s_form = document.getElementById('general_s_form');
        let site_title_inp = document.getElementById('site_title_inp');
        let site_about_inp = document.getElementById('site_about_inp');

        let contacts_s_form = document.getElementById('contacts_s_form');

        let team_s_form = document.getElementById('team_s_form');
        let member_name_inp = document.getElementById('member_name_inp');
        let member_picture_inp = document.getElementById('member_picture_inp');

        function get_general()
        {
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');
            let shutdown_toggle = document.getElementById('shutdown-toggle');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                general_data = JSON.parse(this.responseText);
                
                site_title.innerText = general_data.site_title;
                site_about.innerText = general_data.site_about;

                site_title_inp.value = general_data.site_title;
                site_about_inp.value = general_data.site_about;

                // shutdown == 1 means shutdown is ON → checked
                shutdown_toggle.checked = (general_data.shutdown == 1);
            }

            xhr.send('get_general');
        }

        general_s_form.addEventListener('submit',function(e){
            e.preventDefault(); // prevent form submission
            upd_general(site_title_inp.value,site_about_inp.value)
        })


        function upd_general(site_title_val, site_about_val)
        {
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

            xhr.onload = function(){

                var myModal = document.getElementById('general-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if(this.responseText == 1){
                    alert('success','changes saved!');
                    get_general();
                }
                else{
                    alert('danger','no changes made!');
                }

            }

            xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&upd_general');
        }

        function upd_shutdown(isChecked)
        {
            let val = isChecked ? 1 : 0;

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

            xhr.onload = function()
            {
                if(this.responseText == 1){
                    if(val == 1){
                        alert('success','Site has been shutdown!');
                    } else {
                        alert('success','Shutdown mode disabled!');
                    }
                } else {
                    alert('danger','Operation failed!');
                }

                get_general(); // refresh the toggle state
            }

            xhr.send('upd_shutdown=' + val);
        }

        function get_contacts()
        {
            let contacts_p_id = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
            let iframe = document.getElementById('iframe');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                contacts_data = JSON.parse(this.responseText);
                contacts_data = Object.values(contacts_data);

                for(i=0;i<contacts_p_id.length;i++){
                    document.getElementById(contacts_p_id[i]).innerText = contacts_data[i+1];
                }
                iframe.src = contacts_data[9];
                contacts_inp(contacts_data);
            }

            xhr.send('get_contacts');
        }
        
        function contacts_inp(data)
        {
            let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];

            for(i=0;i<contacts_inp_id.length;i++){
                document.getElementById(contacts_inp_id[i]).value = data[i+1];
            }
        }

        contacts_s_form.addEventListener('submit',function(e){
            e.preventDefault(); // prevent form submission
            upd_contacts();
        })

        function upd_contacts()
        {
            let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw', 'iframe'];
            let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];

            let data_str = "";

            for(i=0;i<index.length;i++){
                data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';
            }

            data_str += "upd_contacts";

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");   

            xhr.onload = function(){
                var myModal = document.getElementById('contacts-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if(this.responseText == 1){
                    alert('success','changes saved!');
                    get_contacts();
                }
                else{
                    alert('danger','no changes made!');
                }
            }

            xhr.send(data_str);
        }

        team_s_form.addEventListener('submit',function(e){
            e.preventDefault(); // prevent form submission
            add_member();
        })

        function add_member()
        {
            let data = new FormData();
            data.append('name', member_name_inp.value);
            data.append('picture', member_picture_inp.files[0]);
            data.append('add_member', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);

            xhr.onload = function(){
                var myModal = document.getElementById('team-s');
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
                    alert('success', 'new member added!');
                     member_name_inp.value='';
                     member_picture_inp.value='';
                     get_members();
                }

            }

            xhr.send(data);
            
        }

        function get_members()
        {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('team-data').innerHTML = this.responseText;
            }

            xhr.send('get_members');
        }

        function del_member(val)
        {
            
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success','member deleted!');
                    get_members();
                }
                else{
                    alert('danger','operation failed!');
                }
            }

            xhr.send('del_member='+val);        
            

        }
        
        window.onload = function(){
            get_general();
            get_contacts();
            get_members();
        }