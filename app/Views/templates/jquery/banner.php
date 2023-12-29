<script>
    const baseUrl = '<?= base_url(); ?>';
    const apiUrl = '<?= getenv('API_URL') ?>';
</script>

<script>
    deleteBanner = async (uid, image) => {
        Swal.fire({
            title: 'Are you sure want to delete?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then(async (result) => {
            if (result.value) {
                let fd = new FormData();
                fd.append('uid', uid);
                fd.append('image', image);
                await $.ajax({
                    type: "POST",
                    url: `${baseUrl}/admin/banner/delete`,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: fd,
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>