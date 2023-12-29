<script>
    const baseUrl = '<?= base_url(); ?>';
    const apiUrl = '<?= getenv('API_URL') ?>';
    const session = '<?= $_SESSION['token'] ?>'
</script>

<script>
    var page = 1; // Mulai dari halaman pertama
    var isLoading = false; // Menandakan apakah sedang dalam proses pengambilan data

    // Fungsi untuk memuat data dari server
    function loadNextPage(page) {

        if (isLoading) return; // Jangan mengambil data jika sedang dalam proses

        isLoading = true;
        let fd = new FormData();
        $('#loading').show(); // Tampilkan pesan loading
        fd.append('page', page)
        console.log("page   ", page);
        $.ajax({
            type: 'POST',
            url: `${baseUrl}/admin/product/page`,
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function(response) {
                $('#loading').hide();
                const parsedResponse = JSON.parse(response); // Mengubah string JSON menjadi objek JavaScript

                var categories = parsedResponse.message;
                var categoryHtml = '';
                console.log(parsedResponse);
                for (var i = 0; i < categories.length; i++) {
                    var statusClass = categories[i].status == 1 ? 'text-success' : 'text-danger';
                    var statusName = categories[i].status == 1 ? 'Active' : 'Non Active';

                    var responseDate = categories[i].created_at;
                    var dateTime = new Date(responseDate);
                    var options = {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        timeZone: 'Asia/Jakarta'
                    };
                    var formattedDate = dateTime.toLocaleString('id-ID', options);


                    var categoryHtml = '<div class="col-xl-4"><div class="card widget widget-connection-request"><div class="card-header"><h5 class="card-title">Games Mobile<span class="badge badge-secondary badge-style-light">' + formattedDate + '</span></h5></div><div class="card-body"><div class="widget-connection-request-container d-flex"><div class="widget-connection-request-avatar"><div class="avatar avatar-xl m-r-xs"><img src="' + apiUrl + categories[i].category_image + '" alt=""></div></div><div class="widget-connection-request-info flex-grow-1"><span class="widget-connection-request-info-name">' + categories[i].category_name + '</span><span class="widget-connection-request-info-count ' + statusClass + '">' + statusName + '</span><span class="widget-connection-request-info-about">' + categories[i].description + '</span></div></div><div class="widget-connection-request-actions d-flex"><a href="<?= base_url('admin/product') ?>/items/' + categories[i].category_id +'" class="btn btn-info btn-style-light flex-grow-1 m-r-xxs"><i class="material-icons">visibility</i>Lihat</a><a href="#" class="btn btn-success btn-style-light flex-grow-1 m-r-xxs" data-bs-toggle="modal" data-bs-target="#edit"><i class="material-icons">edit</i>Edit</a><a href="#" class="btn btn-danger btn-style-light flex-grow-1 m-l-xxs"><i class="material-icons">delete</i>Hapus</a></div></div><a href="#" class="btn btn-warning btn-style-light"><i class="material-icons">flash_on</i>Fast Update Items</a></div></div>';

                    $('#paginations').append(categoryHtml);
                    isLoading = false;
                }
            },
            error: function() {
                isLoading = false;
                $('#loading').hide();
                console.error('Error fetching data.');
            }
        });
    }

    function checkScroll() {
        var windowHeight = $(window).height();
        var documentHeight = $(document).height();
        var scrollTop = $(window).scrollTop();

        if (windowHeight + scrollTop >= documentHeight - 100) {
            if (!isLoading) {
                page++; // Pindah ke halaman berikutnya
                loadNextPage(page);
            }
        }
    }

    $(document).ready(function() {
        loadNextPage(page); // Muat halaman pertama saat dokumen siap
        $(window).scroll(checkScroll); // Menjalankan checkScroll saat pengguna melakukan scroll
    });
</script>