$(document).ready(function(){
    $('#loginForm').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        console.log("Submitting form data:", formData);
        $.ajax({
            type: 'POST',
            url: '/xampp/assignment/src/routes/routes.php',
            data: formData + '&type=login',
            dataType: 'json',
            success: function(response){
                console.log("Login response:", response);
                handleLoginResponse(response);
            },
            error: function(xhr, status, error){
                console.error('AJAX Error:', status, error);
                console.log('Response Text:', xhr.responseText);
                alert('An error occurred while logging in. Please try again.');
            }
        });
    });
});

function handleLoginResponse(response) {
    if (response.success) {
        if (response.redirect) {
            console.log("Redirecting to:", response.redirect);
            window.location.href = response.redirect;
        } else {
            console.error('No redirect URL provided in login response');
            alert('Login successful, but unable to redirect to dashboard.');
        }
    } else {
        console.error('Login failed:', response.message);
        alert('Login failed: ' + response.message);
    }
}

