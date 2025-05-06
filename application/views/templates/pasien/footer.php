</main>
        </div>
    </div>
    <script>
        // CSRF Setup
        let csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

        // Toggle Sidebar
        $('#toggle-sidebar').click(function() {
            $('#sidebar').toggleClass('sidebar-hidden');
        });

        // Real-time Notifikasi with SweetAlert2
        function updateNotifikasi() {
            $.ajax({
                url: '<?= base_url('pasien/get_unread_count'); ?>',
                method: 'POST',
                data: { [csrfName]: csrfHash },
                dataType: 'json',
                success: function(data) {
                    const count = data.count;
                    if (count > 0) {
                        $('#notifikasi-badge, #notifikasi-bell-badge').text(count).removeClass('hidden');
                    } else {
                        $('#notifikasi-badge, #notifikasi-bell-badge').addClass('hidden');
                    }
                }
            });

            $.ajax({
                url: '<?= base_url('pasien/get_new_notifikasi'); ?>',
                method: 'POST',
                data: { last_check: new Date().toISOString().slice(0, 19).replace('T', ' '), [csrfName]: csrfHash },
                dataType: 'json',
                success: function(data) {
                    csrfHash = data.csrfHash;
                    if (data.notifikasi.length > 0) {
                        data.notifikasi.forEach(n => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'info',
                                title: n.pesan,
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                background: '#E0F2FE',
                                iconColor: '#14B8A6'
                            });
                        });
                    }
                }
            });
        }

        // Poll every 30 seconds
        setInterval(updateNotifikasi, 30000);
        updateNotifikasi(); // Initial check
    </script>
</body>
</html>
