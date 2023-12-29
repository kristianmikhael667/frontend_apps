<!-- CONSTANT -->
<script>
    const baseUrl = '<?= base_url(); ?>';
    const apiUrl = '<?= getenv('API_URL') ?>';
</script>

<!-- Login -->
<script>
    login = () => {
        let fd = new FormData();
        var email = $("#email").val();
        var password = $("#password").val();

        fd.append('email', email)
        fd.append('password', password)

        $.ajax({
            type: "POST",
            url: `${baseUrl}admin/auth/login`,
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function(response) {
                console.log("apaa ? ", response);
                const parsedResponse = JSON.parse(response); // Mengubah string JSON menjadi objek JavaScript
                const status = parsedResponse.status;
                const sc = parsedResponse.sc;
                const message = parsedResponse.message;
                
                if (sc == 201) {
                    $.ajax({
                        url: `${baseUrl}/admin/auth/savetoken`, // Ganti dengan URL yang sesuai
                        type: 'POST',
                        data: parsedResponse.token,
                        success: function(response) {
                        location.reload()
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error session'
                            });
                        }
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Fetched',
                        text: 'Data has been fetched successfully!'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching data.'
                });
            }
        })
    }
</script>