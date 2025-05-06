
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Daftar Notifikasi</h2>
            <a href="<?php echo site_url('pasien/mark_all_notifikasi_read'); ?>" class="text-indigo-600 hover:text-indigo-800">Tandai Semua Dibaca</a>
        </div>
        <?php if ($notifikasi): ?>
            <div class="space-y-4">
                <?php foreach ($notifikasi as $item): ?>
                    <div class="p-3 border-b flex justify-between items-center">
                        <div>
                            <p class="<?php echo $item->status == 'belum_dibaca' ? 'font-bold' : ''; ?>"><?php echo $item->pesan; ?></p>
                            <p class="text-sm text-gray-500"><?php echo $item->created_at; ?></p>
                        </div>
                        <?php if ($item->status == 'belum_dibaca'): ?>
                            <a href="<?php echo site_url('pasien/mark_notifikasi_read/' . $item->uuid); ?>" class="text-indigo-600 hover:text-indigo-800">Tandai Dibaca</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Belum ada notifikasi.</p>
        <?php endif; ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        function checkNewNotifications() {
            $.ajax({
                url: '<?php echo site_url('pasien/get_new_notifikasi'); ?>',
                type: 'POST',
                data: {
                    last_check: '<?php echo date('Y-m-d H:i:s'); ?>',
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.notifikasi.length > 0) {
                        response.notifikasi.forEach(function(notif) {
                            var html = '<div class="p-3 border-b flex justify-between items-center">' +
                                '<div><p class="font-bold">' + notif.pesan + '</p>' +
                                '<p class="text-sm text-gray-500">' + notif.created_at + '</p></div>' +
                                '<a href="<?php echo site_url('pasien/mark_notifikasi_read/'); ?>' + notif.uuid + '" class="text-indigo-600 hover:text-indigo-800">Tandai Dibaca</a></div>';
                            $('.space-y-4').prepend(html);
                        });
                    }
                    $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val(response.csrfHash);
                }
            });
        }
        function updateUnreadCount() {
            $.ajax({
                url: '<?php echo site_url('pasien/get_unread_count'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.count > 0) {
                        $('#notifikasi-badge').text(response.count).show();
                    } else {
                        $('#notifikasi-badge').hide();
                    }
                }
            });
        }
        setInterval(checkNewNotifications, 30000); // Cek setiap 30 detik
        setInterval(updateUnreadCount, 30000);
        updateUnreadCount();
    });
</script>
<?php $this->load->view('templates/pasien/footer'); ?>