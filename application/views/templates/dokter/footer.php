</div>
        </div>
    </div>

    <!-- JavaScript for Interactivity -->
    <script>
        $(document).ready(function () {
            // Toggle Sidebar on Mobile
            $('#openSidebar').click(function () {
                $('.sidebar').addClass('active');
            });

            $('#toggleSidebar').click(function () {
                $('.sidebar').removeClass('active');
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function (e) {
                if ($(window).width() < 640 && !$(e.target).closest('.sidebar').length && !$(e.target).closest('#openSidebar').length) {
                    $('.sidebar').removeClass('active');
                }
            });

            // Fetch Unread Notification Count Periodically
            function fetchUnreadNotifications() {
                $.ajax({
                    url: '<?php echo base_url('dokter/get_unread_count'); ?>',
                    method: 'POST',
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.count > 0) {
                            $('.notifikasi-count').text(response.count).show();
                        } else {
                            $('.notifikasi-count').hide();
                        }
                        // Update CSRF token after each request
                        var newCsrfToken = response.csrf_token;
                        if (newCsrfToken) {
                            $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val(newCsrfToken);
                        }
                    },
                    error: function () {
                        console.log('Gagal mengambil notifikasi.');
                    }
                });
            }

            // Run fetchUnreadNotifications every 30 seconds
            setInterval(fetchUnreadNotifications, 30000);
            fetchUnreadNotifications(); // Initial fetch
        });
    </script>
</body>
</html>