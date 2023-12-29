<!-- Javascripts -->
<script src="<?= base_url('/plugins/jquery/jquery-3.5.1.min.js') ?>"></script>
<script src="<?= base_url('/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('/plugins/perfectscroll/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('/plugins/pace/pace.min.js') ?>"></script>
<script src="<?= base_url('/plugins/apexcharts/apexcharts.min.js') ?>"></script>
<script src="<?= base_url('/js/main.min.js') ?>"></script>
<script src="<?= base_url('/js/custom.js') ?>"></script>
<script src="<?= base_url('/js/pages/dashboard.js') ?>"></script>

<script src="<?= base_url('/js/pages/widgets.js') ?>"></script>
<script src="<?= base_url('/plugins/highlight/highlight.pack.js') ?>"></script>
<script src="<?= base_url('/plugins/dropzone/min/dropzone.min.js') ?>"></script>

<script src="<?= base_url('/plugins/bootstrap/js/popper.min.js') ?>"></script>
<script src="<?= base_url('/plugins/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('/js/pages/datatables.js') ?>"></script>

<script src="<?= base_url('/plugins/flatpickr/flatpickr.js') ?>"></script>
<script src="<?= base_url('/js/pages/datepickers.js') ?>"></script>
<script src="<?= base_url('/plugins/select2/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('/js/pages/select2.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="
https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js
"></script>

<script>
    $('.dropify').dropify();
</script>

<!-- Logout -->
<script>
    logout = async () => {
        Swal.fire({
            title: 'Are you sure want to logout?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then(async (result) => {
            if (result.value) {
                await $.ajax({
                    type: "POST",
                    url: `${baseUrl}/admin/auth/logout`,
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>

<!-- WebSocket -->
<script>
    document.getElementById("messages").style.display = 'none';

    function showMessage(message) {
        const messages = document.getElementById('messages');
        messages.textContent = message;
        messages.style.display = 'block';
        
        setTimeout(() => {
            messages.style.display = 'none';
        }, 10000);
    }

    function playNotificationSound() {
        const audio = document.getElementById('notificationSound');
        audio.play().catch(error => {
            console.error('Failed to play audio:', error);
        });
    }

    const socket = new WebSocket('ws://localhost:3000/jelajah-teknologi-negeri/ws');

    socket.addEventListener('open', (event) => {
        console.log('WebSocket connection opened:', event);
    });

    socket.addEventListener('message', (event) => {
        showMessage(event.data);
    });

    socket.addEventListener('close', (event) => {
        console.log('WebSocket connection closed:', event);
    });

    socket.addEventListener('error', (event) => {
        console.error('WebSocket error:', event);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            const input = document.getElementById('inputMessage');
            const message = input.value;
            socket.send(message);
            input.value = '';
        }
    });
</script>