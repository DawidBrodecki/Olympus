$(function() {
 
                if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#remember-me').attr('checked', 'checked');
                    $('#login').val(localStorage.usrname);
                    $('#your_pass').val(localStorage.pass);
                } else {
                    $('#remember-me').removeAttr('checked');
                    $('#login').val('');
                    $('#your_pass').val('');
                }
 
                $('#remember-me').click(function() {
 
                    if ($('#remember-me').is(':checked')) {
                        // save username and password
                        localStorage.usrname = $('#login').val();
                        localStorage.pass = $('#your_pass').val();
                        localStorage.chkbx = $('#remember-me').val();
                    } else {
                        localStorage.usrname = '';
                        localStorage.pass = '';
                        localStorage.chkbx = '';
                    }
                });
            });